<?php
require_once __DIR__ . '/../../functions/autoload.php';

// descomentar para hacer autenticacion
Autenticacion::verify(true);
?>
<h2>Agregar una nueva categoria</h2>
<form action="actions/crear_categoria_acc.php" method="post" enctype="multipart/form-data" required>
    <div class="mb-3">
        <label for="categoria" class="form-label">Nombre de categoria</label>
        <input type="text" class="form-control" id="categoria" name="categoria">
    </div>
    <input type="submit" value="Crear" class="btn btn-dark py-3 px-5">
    <a href="?sec=categorias" class="btn btn-danger py-3 px-5 text-white">Cancelar</a>
</form>