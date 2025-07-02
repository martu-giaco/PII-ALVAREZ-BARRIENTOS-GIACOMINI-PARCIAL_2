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
    public function getId() { return $this->id; }
    public function getUsuario() { return $this->usuario; }
    public function getNombre() { return $this->nombre; }
    public function getRol() { return $this->rol; }

    /**
     * 🔐 Autenticación del usuario (sin session, sin cookie)
     * Devuelve un objeto Usuario si las credenciales son válidas, o null si fallan.
     */
    public static function autenticar(string $usuario, string $password): ?self
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $stmt = $conexion->prepare($query);
        $stmt->execute(['usuario' => $usuario]);

        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$datos) return null;

        $passwordIngresada = hash("sha256", $password);

        if ($datos['password'] === $passwordIngresada) {
            return new self(
                $datos['id'],
                $datos['usuario'],
                $datos['password'],
                $datos['nombre'],
                $datos['rol']
            );
        }

        return null;
    }

    // === CRUD ===

    public static function getPorId(int $id): ?self
    {
        $conexion = (new Conexion())->getConexion();

        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$fila) return null;

        return new self(
            $fila['id'],
            $fila['usuario'],
            $fila['password'],
            $fila['nombre'],
            $fila['rol']
        );
    }

    public static function todos(): array
    {
        $conexion = (new Conexion())->getConexion();

        $stmt = $conexion->prepare("SELECT * FROM usuarios");
        $stmt->execute();

        $usuarios = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
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

    public static function crear(string $usuario, string $password, string $nombre, string $rol = 'cliente'): bool
    {
        $conexion = (new Conexion())->getConexion();

        $hash = hash("sha256", $password);

        $stmt = $conexion->prepare("INSERT INTO usuarios (usuario, password, nombre, rol)
                                    VALUES (:usuario, :password, :nombre, :rol)");

        return $stmt->execute([
            'usuario' => $usuario,
            'password' => $hash,
            'nombre' => $nombre,
            'rol' => $rol
        ]);
    }

    public static function eliminar(int $id): bool
    {
        $conexion = (new Conexion())->getConexion();

        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public static function editar(int $id, string $nombre, string $rol): bool
    {
        $conexion = (new Conexion())->getConexion();

        $stmt = $conexion->prepare("UPDATE usuarios SET nombre = :nombre, rol = :rol WHERE id = :id");

        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'rol' => $rol
        ]);
    }
}
