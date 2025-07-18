<?php
require_once __DIR__ . '/Conexion.php';

class Usuario
{
    private $id_usuario;
    private $usuario;
    private $email;
    private $clave;

    public function __construct(array $data)
    {
        $this->id_usuario = $data['id_usuario'];
        $this->usuario = $data['usuario'];
        $this->email = $data['email'];
        $this->clave = $data['clave'];
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Devuelve "admin" o "usuario" según el ID de rol
     */
    public function getRol(): string
    {
        $conexion = (new Conexion())->getConexion();

        $query = "
            SELECT r.rol
            FROM usuario_rol ur
            JOIN roles r ON ur.id_rol = r.id_rol
            WHERE ur.id_usuario = :id_usuario
            LIMIT 1
        ";

        $stmt = $conexion->prepare($query);
        $stmt->execute(['id_usuario' => $this->id_usuario]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['rol'] : 'usuario'; // por defecto retorna "usuario"
    }

    /**
     * Devuelve el usuario según nombre de usuario o email
     */
    public static function obtenerPorUsuarioEmail(string $usuario): ?Usuario
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT * FROM usuarios WHERE usuario = :usuario OR email = :usuario LIMIT 1";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(['usuario' => $usuario]);

        $data = $PDOStatement->fetch(PDO::FETCH_ASSOC);

        return $data ? new Usuario($data) : null;
    }

    public static function obtenerUsuariosConInactivos(): array
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT * FROM usuarios ORDER BY id_usuario";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute();

        $usuariosData = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        $usuarios = [];

        foreach ($usuariosData as $user) {
            $usuario = new Usuario($user);
            $usuario->activo = $user['activo'] ?? 1;  // agregar propiedad dinámica para estado
            $usuarios[] = $usuario;
        }

        return $usuarios;
    }

    
    public static function get_x_id(int $id): ?Usuario
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT id_usuario, usuario, email, clave FROM usuarios WHERE id_usuario = :id LIMIT 1";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(['id' => $id]);

        $user = $PDOStatement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null; // No se encontró
        }

        return new Usuario($user['id_usuario'], $user['usuario'], $user['email'], $user['clave']);
    }

    //Inserta un nuevo usuario en la base de datos
    public static function insert($usuario, $email, $clave, $rol) {
        $db = (new Conexion())->getConexion();

        $stmt = $db->prepare("INSERT INTO usuarios (usuario, email, clave, rol) VALUES (?, ?, ?, ?)");
        $stmt->execute([$usuario, $email, $clave, $rol]);
    }

    public function eliminarUsuario(): bool
    {
        $conexion = (new Conexion())->getConexion();

        $query = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
        $PDOStatement = $conexion->prepare($query);

        return $PDOStatement->execute(['id_usuario' => $this->id_usuario]);
    }

    public static function obtenerUsuarios(): array
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT id_usuario, usuario, email, clave FROM usuarios WHERE activo = 1 ORDER BY usuario";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute();

        $usuariosData = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        $usuarios = [];

        foreach ($usuariosData as $user) {
            $usuarios[] = new Usuario($user['id_usuario'], $user['usuario'], $user['email'], $user['clave']);
        }

        return $usuarios;
    }

}
