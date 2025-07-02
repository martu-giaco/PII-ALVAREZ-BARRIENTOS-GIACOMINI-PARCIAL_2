<?php
?>
<h2>Agregar una nueva categoria</h2>
<form action="actions/crear_categoria_acc.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="categoria" class="form-label">Nombre de categoria</label>
        <input type="text" class="form-control" id="categoria" name="categoria">
    </div>
    <input type="submit" value="Crear">
    <a href="?sec=categorias" class="btn btn-danger">Cancelar</a>
</form>