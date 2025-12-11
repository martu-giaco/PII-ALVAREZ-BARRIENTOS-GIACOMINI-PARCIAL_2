<?php 
require_once __DIR__ . '/../../functions/autoload.php';

// descomentar para hacer autenticacion
Autenticacion::verify(true);

// Mantener compatibilidad: obtener lista si se requiere en otros fragmentos
$lista = Usuario::obtenerUsuarios();

$id = $_GET['id'] ?? FALSE;
$usuario = Usuario::get_x_id($id);

if (!$usuario) {
    die("Usuario no encontrado.");
}

// Obtener roles desde la tabla `roles`
$roles = [];
try {
    $db = (new Conexion())->getConexion();
    $roles = $db->query("SELECT id_rol, rol FROM roles ORDER BY id_rol")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $roles = [];
}

// Obtener id_rol actual del usuario (si existe)
$rolActualId = null;
try {
    $stmt = (new Conexion())->getConexion()->prepare("SELECT id_rol FROM usuario_rol WHERE id_usuario = :id_usuario LIMIT 1");
    $stmt->execute(['id_usuario' => $usuario->getIdUsuario()]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $rolActualId = $row['id_rol'];
    }
} catch (Exception $e) {
    $rolActualId = null;
}
?>

<h2>Editar usuario</h2>
<form action="actions/editar_usuario_acc.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_usuario" class="form-control" id="id_usuario" value="<?= $usuario->getIdusuario(); ?>" >

    <div class="mb-3">
        <label for="usuario" class="form-label">Nombre de usuario</label>
        <input type="text" class="form-control" id="usuario" name="usuario" value="<?= $usuario->getUsuario(); ?>">
    </div>
    
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $usuario->getEmail(); ?>">
    </div>
    <div class="mb-3">
        <label for="clave" class="form-label">Clave</label>
        <input type="password" class="form-control" id="clave" name="clave" value="<?= $usuario->getClave(); ?>">
    </div>

    <div class="mb-3">
        <label for="rol" class="form-label">Rol</label>

        <?php if (!empty($roles)): ?>
            <select id="rol" name="rol" class="form-select">
                <option value="">Seleccione un rol para este usuario</option>
                <?php foreach ($roles as $r): ?>
                    <option value="<?= htmlspecialchars($r['id_rol']); ?>"
                        <?= ($rolActualId !== null && (int)$rolActualId === (int)$r['id_rol']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['rol']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <select id="rol" name="rol" class="form-select">
                <option value="">No hay roles definidos en la base de datos</option>
            </select>
        <?php endif; ?>
    </div>

    <input type="submit"  class="btn btn-dark py-3 px-5" value="Editar">
    <a href="?sec=usuarios" class="btn btn-danger text-white py-3 px-5">Cancelar</a>
</form>
