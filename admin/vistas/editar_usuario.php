<?php 
require_once __DIR__ . '/../../functions/autoload.php';
Autenticacion::verify(true);

$id = $_GET['id'] ?? null;
if (!$id) die("ID de usuario no proporcionado.");

$usuario = Usuario::get_x_id($id);
if (!$usuario) die("Usuario no encontrado.");

// Obtener roles desde la base
try {
    $db = (new Conexion())->getConexion();
    $roles = $db->query("SELECT id_rol, rol FROM roles ORDER BY id_rol")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $roles = [];
}

// Obtener rol actual del usuario
$rolActualId = null;
if ($roles) {
    try {
        $stmt = $db->prepare("SELECT id_rol FROM usuario_rol WHERE id_usuario = :id_usuario LIMIT 1");
        $stmt->execute(['id_usuario' => $usuario->getIdUsuario()]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $rolActualId = $row['id_rol'] ?? null;
    } catch (Exception $e) {
        $rolActualId = null;
    }
}

// Ruta base del admin
$admin_base = rtrim(dirname($_SERVER['PHP_SELF']), '/');
?>

<h2>Editar usuario</h2>

<!-- Mostrar alertas si existen -->
<?= Alerta::get_alertas(); ?>

<form action="<?= $admin_base; ?>/actions/editar_usuario_acc.php" method="post">
    <input type="hidden" name="id_usuario" value="<?= $usuario->getIdUsuario(); ?>">

    <!-- Nombre de usuario -->
    <div class="mb-3">
        <label for="usuario" class="form-label">Nombre de usuario</label>
        <input type="text" id="usuario" name="usuario" class="form-control" 
               value="<?= htmlspecialchars($usuario->getUsuario()); ?>" required>
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" 
               value="<?= htmlspecialchars($usuario->getEmail()); ?>" required>
    </div>

    <!-- Clave -->
    <div class="mb-3">
        <label for="clave" class="form-label">Clave (dejar vacío para no cambiar)</label>
        <input type="password" id="clave" name="clave" class="form-control" placeholder="********">
    </div>

    <!-- Rol -->
    <div class="mb-3">
        <label for="rol" class="form-label">Rol</label>
        <select id="rol" name="rol" class="form-select" required>
            <option value="">Seleccione un rol</option>
            <?php foreach ($roles as $r): ?>
                <option value="<?= $r['id_rol']; ?>" <?= ($rolActualId == $r['id_rol']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($r['rol']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Botones -->
    <button type="submit" class="btn btn-dark py-3 px-5">Editar</button>
    <a href="<?= $admin_base; ?>/?sec=usuarios" class="btn btn-danger text-white py-3 px-5">Cancelar</a>
</form>
