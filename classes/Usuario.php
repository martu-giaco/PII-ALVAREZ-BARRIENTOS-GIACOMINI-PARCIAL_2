<?php
require_once __DIR__ . '/Conexion.php';

class Usuario
{
    private $id_usuario;
    private $usuario;
    private $email;
    private $clave;
    public $activo;

    public function __construct(array $data)
    {
        $this->id_usuario = $data['id_usuario'] ?? null;
        $this->usuario    = $data['usuario'] ?? null;
        $this->email      = $data['email'] ?? null;
        $this->clave      = $data['clave'] ?? null;
        $this->activo     = $data['activo'] ?? 1;
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
     * Obtiene el rol real desde la tabla usuario_rol y roles
     */
    public function getRol(): string
    {
        $db = (new Conexion())->getConexion();

        $query = "
            SELECT r.rol 
            FROM usuario_rol ur
            JOIN roles r ON ur.id_rol = r.id_rol
            WHERE ur.id_usuario = :id
            LIMIT 1
        ";

        $stmt = $db->prepare($query);
        $stmt->execute(['id' => $this->id_usuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $row['rol'] : 'usuario';
    }

    /**
     * Devuelve el id_rol asociado al usuario (o null si no existe)
     */
    public function getIdRol(): ?int
    {
        $db = (new Conexion())->getConexion();

        $stmt = $db->prepare("SELECT id_rol FROM usuario_rol WHERE id_usuario = :id LIMIT 1");
        $stmt->execute(['id' => $this->id_usuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? (int)$row['id_rol'] : null;
    }

    /**
     * Obtener usuario por usuario O email (para login)
     * Nombre original: obtenerPorUsuarioEmail
     */
    public static function obtenerPorUsuarioEmail(string $usuario): ?Usuario
    {
        $db = (new Conexion())->getConexion();

        $query = "SELECT * FROM usuarios WHERE usuario = :u OR email = :u LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->execute(['u' => $usuario]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Usuario($data) : null;
    }

    /**
     * Método buscado por Autenticacion: usuario_x_email
     * Busca por email exacto y devuelve un objeto Usuario o null.
     */
    public static function usuario_x_email(string $email): ?Usuario
    {
        $db = (new Conexion())->getConexion();

        $query = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->execute(['email' => $email]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Usuario($data) : null;
    }

    /**
     * Usuarios incluyendo inactivos
     */
    public static function obtenerUsuariosConInactivos(): array
    {
        $db = (new Conexion())->getConexion();

        $query = "SELECT * FROM usuarios ORDER BY id_usuario";
        $stmt = $db->query($query);

        $usuarios = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $u) {
            $usuarios[] = new Usuario($u);
        }

        return $usuarios;
    }

    /**
     * Usuarios activos
     */
    public static function obtenerUsuarios(): array
    {
        $db = (new Conexion())->getConexion();

        $query = "SELECT * FROM usuarios WHERE activo = 1 ORDER BY usuario";
        $stmt = $db->query($query);

        $usuarios = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $u) {
            $usuarios[] = new Usuario($u);
        }

        return $usuarios;
    }

    /**
     * Obtener usuario por ID
     */
    public static function get_x_id(int $id): ?Usuario
    {
        $db = (new Conexion())->getConexion();

        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id_usuario = :id LIMIT 1");
        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Usuario($data) : null;
    }

    /**
     * Insertar usuario + asignar rol (devuelve id insertado)
     */
    public static function insert(string $usuario, string $email, string $clave, int $rol)
    {
        $db = (new Conexion())->getConexion();

        // Hashear la clave
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);

        $stmt = $db->prepare("
            INSERT INTO usuarios (usuario, email, clave, activo)
            VALUES (:usuario, :email, :clave, 1)
        ");
        $stmt->execute([
            ':usuario' => $usuario,
            ':email'   => $email,
            ':clave'   => $claveHash
        ]);

        $id = $db->lastInsertId();

        // Insertar en tabla intermedia usuario_rol
        $stmt2 = $db->prepare("
            INSERT INTO usuario_rol (id_usuario, id_rol)
            VALUES (:id_usuario, :id_rol)
        ");
        $stmt2->execute([
            ':id_usuario' => $id,
            ':id_rol'     => $rol
        ]);

        return $id;
    }

    /**
     * Editar usuario
     */
    public function update(string $usuario, string $email, string $clave)
    {
        $db = (new Conexion())->getConexion();

        // Si la clave NO está hasheada, la hasheamos
        $claveHash = (strlen($clave) < 60) ? password_hash($clave, PASSWORD_DEFAULT) : $clave;

        $stmt = $db->prepare("
            UPDATE usuarios 
            SET usuario = :usuario, email = :email, clave = :clave
            WHERE id_usuario = :id_usuario
        ");

        return $stmt->execute([
            ':usuario'   => $usuario,
            ':email'     => $email,
            ':clave'     => $claveHash,
            ':id_usuario'=> $this->id_usuario
        ]);
    }

    /**
     * Desactivar usuario
     */
    public function desactivar()
    {
        $db = (new Conexion())->getConexion();
        $stmt = $db->prepare("UPDATE usuarios SET activo = 0 WHERE id_usuario = ?");
        return $stmt->execute([$this->id_usuario]);
    }

    /**
     * Reactivar usuario
     */
    public function reactivar()
    {
        $db = (new Conexion())->getConexion();
        $stmt = $db->prepare("UPDATE usuarios SET activo = 1 WHERE id_usuario = ?");
        return $stmt->execute([$this->id_usuario]);
    }

    /**
     * Eliminar usuario correctamente (primero borrar FK)
     */
    public function eliminarUsuario(): bool
    {
        $db = (new Conexion())->getConexion();

        // Usar transacción para mayor seguridad
        try {
            $db->beginTransaction();

            // Eliminar su relación en usuario_rol primero
            $stmt = $db->prepare("DELETE FROM usuario_rol WHERE id_usuario = :id_usuario");
            $stmt->execute([':id_usuario' => $this->id_usuario]);

            // Ahora sí eliminar usuario
            $stmt2 = $db->prepare("DELETE FROM usuarios WHERE id_usuario = :id_usuario");
            $result = $stmt2->execute([':id_usuario' => $this->id_usuario]);

            $db->commit();

            return (bool)$result;
        } catch (Exception $e) {
            if ($db->inTransaction()) $db->rollBack();
            throw $e;
        }
    }
}
