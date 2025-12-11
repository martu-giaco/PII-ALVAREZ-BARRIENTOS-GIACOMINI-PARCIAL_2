<?php
require_once __DIR__ . '/../../functions/autoload.php';

// Autenticación: solo admin puede crear usuarios
Autenticacion::verify(true);

// Inicializar valores previos para repoblar el formulario si hubo error
$usuario_val = $_SESSION['old_usuario'] ?? '';
$email_val = $_SESSION['old_email'] ?? '';
$clave_val = $_SESSION['old_clave'] ?? '';
$rol_val = $_SESSION['old_rol'] ?? '';

// Limpiar valores antiguos de sesión
unset($_SESSION['old_usuario'], $_SESSION['old_email'], $_SESSION['old_clave'], $_SESSION['old_rol']);

// Obtener lista de roles desde la base
$roles = [];
try {
    $db = (new Conexion())->getConexion();
    $roles = $db->query("SELECT * FROM roles ORDER BY rol")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $roles = [];
}
?>

<h2>Crear Usuario</h2>

<?= Alerta::get_alertas(); ?>

<form action="actions/crear_usuario_acc.php" method="post">
    <div class="mb-3">
        <label for="usuario" class="form-label">Nombre de usuario</label>
        <input type="text" class="form-control" id="usuario" name="usuario" 
               value="<?= htmlspecialchars($usuario_val); ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" 
               value="<?= htmlspecialchars($email_val); ?>" required>
    </div>

    <div class="mb-3">
        <label for="clave" class="form-label">Clave</label>
        <input type="password" class="form-control" id="clave" name="clave" 
               value="<?= htmlspecialchars($clave_val); ?>" required>
    </div>

    <div class="mb-3">
        <label for="rol" class="form-label">Rol</label>
        <select id="rol" name="rol" class="form-select" required>
            <option value="">Seleccione un rol para este usuario</option>
            <?php if (!empty($roles)): ?>
                <?php foreach ($roles as $r): ?>
                    <option value="<?= htmlspecialchars($r['id_rol']); ?>" 
                        <?= ($rol_val == $r['id_rol']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($r['rol']); ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="1" <?= ($rol_val == '1') ? 'selected' : ''; ?>>admin</option>
                <option value="2" <?= ($rol_val == '2') ? 'selected' : ''; ?>>usuario</option>
            <?php endif; ?>
        </select>
    </div>

    <input type="submit" class="btn btn-primary py-3 px-5" value="Crear Usuario">
    <a href="?sec=usuarios" class="btn btn-danger text-white py-3 px-5">Cancelar</a>
</form>
