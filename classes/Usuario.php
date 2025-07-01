<?php
require_once __DIR__ . '/Conexion.php';

class Usuario
{
    private $id;
    private $usuario;
    private $password;
    private $nombre;
    private $rol;

    public function __construct($id = null, $usuario = null, $password = null, $nombre = null, $rol = 'cliente')
    {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->rol = $rol;
    }

    // === GETTERS ===
    public function getId()
    {
        return $this->id;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * 🔐 Autenticación del usuario
     */
    public static function autenticar(string $usuario, string $password): bool
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(['usuario' => $usuario]);

        $datos = $PDOStatement->fetch(PDO::FETCH_ASSOC);

        if (!$datos) {
            return false;
        }

        $passwordIngresada = hash("sha256", $password);

        if ($datos['password'] === $passwordIngresada) {
            $_SESSION['id_usuario'] = $datos['id'];
            $_SESSION['nombre_usuario'] = $datos['nombre'];
            $_SESSION['rol'] = $datos['rol'];
            return true;
        }

        return false;
    }

    /**
     * 🔎 Obtener un usuario por ID
     */
    public static function getPorId(int $id): ?self
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT * FROM usuarios WHERE id = :id";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(['id' => $id]);

        $fila = $PDOStatement->fetch(PDO::FETCH_ASSOC);

        if (!$fila)
            return null;

        return new self(
            $fila['id'],
            $fila['usuario'],
            $fila['password'],
            $fila['nombre'],
            $fila['rol']
        );
    }

    /**
     * 📋 Listar todos los usuarios
     */
    public static function todos(): array
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT * FROM usuarios";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute();

        $datos = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        $usuarios = [];

        foreach ($datos as $fila) {
            $usuarios[] = new self(
                $fila['id'],
                $fila['usuario'],
                $fila['password'],
                $fila['nombre'],
                $fila['rol']
            );
        }

        return $usuarios;
    }

    /**
     * ➕ Crear nuevo usuario
     */
    public static function crear(string $usuario, string $password, string $nombre, string $rol = 'cliente'): bool
    {
        $conexion = (new Conexion())->getConexion();

        $hash = hash("sha256", $password);

        $query = "INSERT INTO usuarios (usuario, password, nombre, rol) 
                  VALUES (:usuario, :password, :nombre, :rol)";
        $PDOStatement = $conexion->prepare($query);

        return $PDOStatement->execute([
            'usuario' => $usuario,
            'password' => $hash,
            'nombre' => $nombre,
            'rol' => $rol
        ]);
    }

    /**
     * 🗑 Eliminar usuario por ID
     */
    public static function eliminar(int $id): bool
    {
        $conexion = (new Conexion())->getConexion();

        $query = "DELETE FROM usuarios WHERE id = :id";
        $PDOStatement = $conexion->prepare($query);

        return $PDOStatement->execute(['id' => $id]);
    }

    /**
     * ✏️ Editar nombre y rol del usuario
     */
    public static function editar(int $id, string $nombre, string $rol): bool
    {
        $conexion = (new Conexion())->getConexion();

        $query = "UPDATE usuarios SET nombre = :nombre, rol = :rol WHERE id = :id";
        $PDOStatement = $conexion->prepare($query);

        return $PDOStatement->execute([
            'id' => $id,
            'nombre' => $nombre,
            'rol' => $rol
        ]);
    }

    // === FUNCIONES AUXILIARES DE ROL ===

    /**
     * Verifica si hay un usuario logueado.
     */
    function estaAutorizado(): bool
    {
        return isset($_SESSION['id_usuario']);
    }

    /**
     * Verifica si el usuario logueado es administrador.
     */
    function esAdmin(): bool
    {
        return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
    }

    /**
     * Verifica si el usuario es cliente.
     */
    function esCliente(): bool
    {
        return isset($_SESSION['rol']) && $_SESSION['rol'] === 'cliente';
    }

}
