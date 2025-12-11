<?php
require_once __DIR__ . '/../../functions/autoload.php';

// descomentar para hacer autenticacion
Autenticacion::verify(true);

// Preparar objeto usuario vacío (mantener estructura original)
$usuario = new Usuario([
    'id_usuario' => '',
    'usuario' => '',
    'email' => '',
    'clave' => ''
]);

// Intentar obtener lista de roles desde la tabla `roles`.
// Si la tabla no existe o falla la consulta, $roles quedará vacío.
$roles = [];
try {
    $db = (new Conexion())->getConexion();
    $roles = $db->query("SELECT * FROM roles ORDER BY rol")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // fallback: dejar $roles vacío para que el formulario siga funcionando
    $roles = [];
}
?>

<h2>Crear Usuario</h2>
<form action="actions/crear_usuario_acc.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_usuario" class="form-control" id="id_usuario">

    <div class="mb-3">
        <label for="usuario" class="form-label">Nombre de usuario</label>
        <input type="text" class="form-control" id="usuario" name="usuario">
    </div>
    
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <div class="mb-3">
        <label for="clave" class="form-label">Clave</label>
        <input type="password" class="form-control" id="clave" name="clave">
    </div>

    <div class="mb-3">
        <label for="rol" class="form-label">Rol</label>

        <?php if (!empty($roles)): ?>
            <select id="rol" name="rol" class="form-select">
                <option value="">Seleccione un rol para este usuario</option>
                <?php foreach ($roles as $r): ?>
                    <option value="<?= htmlspecialchars($r['id_rol']); ?>"><?= htmlspecialchars($r['rol']); ?></option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <!-- Si no hay tabla roles o no hay roles, mostrar un select mínimo con opciones comunes -->
            <select id="rol" name="rol" class="form-select">
                <option value="">Seleccione un rol para este usuario</option>
                <option value="1">admin</option>
                <option value="2">usuario</option>
            </select>
        <?php endif; ?>
    </div>

    <input type="submit"  class="btn btn-primary py-3 px-5" value="Crear Usuario">
    <a href="?sec=usuarios" class="btn btn-danger text-white py-3 px-5">Cancelar</a>
</form>
