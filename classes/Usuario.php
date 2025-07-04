<?php
require_once __DIR__ . '/Conexion.php';

class Usuario
{
    private $id_usuario;
    private $usuario;
    private $email;
    private $clave;
    private $rol;

    public function __construct(array $data)
    {
        $this->id_usuario = $data['id_usuario'];
        $this->usuario = $data['usuario'];
        $this->email = $data['email'];
        $this->clave = $data['clave'];
        $this->rol = $data['rol'];
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
    public function getRol()
    { 
        return $this->rol; 
    }

    public static function obtenerPorUsuarioEmail(string $usuario): ?Usuario
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT u.*, r.rol 
                FROM usuarios u
                JOIN usuario_rol ur ON u.id_usuario = ur.id_usuario
                JOIN roles r ON ur.id_rol = r.id_rol
                WHERE u.usuario = :usuario OR u.email = :usuario
                LIMIT 1";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(['usuario' => $usuario]);

        $data = $PDOStatement->fetch(PDO::FETCH_ASSOC);

        return $data ? new Usuario($data) : null;
    }

    
}
