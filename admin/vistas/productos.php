<?php 

require_once("../functions/autoload.php");

Autenticacion::verify();


$producto = new Producto;

$lista = $producto->todosProductos();
?>
<h2>Administración de Productos</h2>
<?= Alerta::get_alertas(); ?>
<table class="table table-striped">
<thead>
<tr>
    <th>ID</th>
    <th>Categoria</th>
    <th>Nombre</th>
    <th>Presentación</th>
    <th>Precio</th>
    <th>Foto</th>
    <th>Likes</th>
    <th>Opciones</th>
</tr>
</thead>
<tbody>

<?php
foreach ($lista as $producto) {
    ?>
    <tr>
        <td><?= $producto->getIdProducto();?></td>
        <td><?= $producto->getCategoria();?></td>
        <td><?= $producto->getNombre();?></td>
        <td><?= $producto->getPresentacion();?></td>
        <td><?= $producto->getPrecio();?></td>
        <td><img src="../img/productos/<?= $producto->getFoto();?>" alt="Imagen producto" width="100"></td>
        <td><?php
            if(count($producto->getLikeNombreUsuario())>0){
                echo "<ul>";
                foreach ($producto->getLikeNombreUsuario() as $key => $U) {
                    echo "<li>" . $U->getNombre() . "</li>";
                }
                echo "</ul>";
            }
        
        ?></td>
        <td>
        <a href="?sec=editar_producto&id=<?= $producto->getIdProducto();?>" class="btn btn-warning">Editar</a>
        <a href="?sec=borrar_producto&id=<?= $producto->getIdProducto();?>" class="btn btn-danger">Borrar</a>
    </td>
    </tr> 
    <?php   
}

?>
</tbody>
</table>

<a href="?sec=crear_producto" class="btn btn-primary">Crear Producto</a>
