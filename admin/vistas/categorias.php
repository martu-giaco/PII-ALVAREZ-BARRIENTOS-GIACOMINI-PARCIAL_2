<?php 
// require_once("../classes/Categoria.php");
require_once("../functions/autoload.php");
Autenticacion::verify();


$categorias = new Categoria;


$lista = $categorias->obtenerCategorias();
?>
<h2>Administración de Categorías</h2>
<table class="table table-striped">
<thead>
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Opciones</th>
</tr>
</thead>
<tbody>

<?php
foreach ($lista as $categoria) {
    ?>
    <tr>
        <td><?= $categoria->getIdCategoria();?></td>
        <td><?= $categoria->getNombreCategoria();?></td>
        <td>
        <a href="?sec=editar_categoria&id=<?= $categoria->getIdCategoria();?>" class="btn btn-warning">Editar</a>
        <a href="?sec=borrar_categoria&id=<?= $categoria->getIdCategoria();?>" class="btn btn-danger">Borrar</a>
    </td>
    </tr> 
    <?php   
}


?>
</tbody>
</table>

<a href="?sec=crear_categoria" class="btn btn-primary">Crear Categoria</a>
