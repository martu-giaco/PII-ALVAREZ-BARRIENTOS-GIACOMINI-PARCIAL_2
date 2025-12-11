<?php
// actions/editar_producto_acc.php
require_once __DIR__ . '/../../functions/autoload.php';

// descomentar si hace falta autenticacion
Autenticacion::verify(true);

try {
    // Asegurarnos de que venga el id por POST
    if (empty($_POST['id_producto'])) {
        throw new Exception("Falta el ID del producto (id_producto).");
    }

    $idProducto = intval($_POST['id_producto']);
    $producto = Producto::get_x_id($idProducto);
    if (!$producto) {
        throw new Exception("Producto no encontrado.");
    }

    // Directorio donde guardamos las imágenes — debe coincidir con la vista
    $uploadDir = __DIR__ . "/../../assets/imagenes/prods/";
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        throw new Exception("No se pudo crear el directorio de imágenes ({$uploadDir}).");
    }

    // Por defecto: no hay nueva imagen -> pasamos null para que edit() preserve la actual
    $imagenFinal = null;
    $fileInput = $_FILES['foto'] ?? null;

    if ($fileInput !== null && $fileInput['error'] !== UPLOAD_ERR_NO_FILE) {
        // Hubo intento de subir archivo: validar errores
        if ($fileInput['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error en la subida de archivo (code: " . $fileInput['error'] . ").");
        }
        if (!is_uploaded_file($fileInput['tmp_name'])) {
            throw new Exception("Archivo subido inválido.");
        }

        // Validar tipo/extension
        $allowedExt = ['jpg','jpeg','png','gif','webp'];
        $info = pathinfo($fileInput['name']);
        $ext = strtolower($info['extension'] ?? '');
        if (!in_array($ext, $allowedExt, true)) {
            throw new Exception("Extensión no permitida. Permitidas: " . implode(", ", $allowedExt));
        }

        // Generar nombre seguro y único para evitar cache/colisiones
        $safeBase = preg_replace('/[^a-zA-Z0-9-_]/', '_', $info['filename']);
        $newFilename = $safeBase . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $targetPath = $uploadDir . $newFilename;

        // Mover archivo
        if (!move_uploaded_file($fileInput['tmp_name'], $targetPath)) {
            throw new Exception("No se pudo mover el archivo subido al directorio destino.");
        }

        @chmod($targetPath, 0644);
        $imagenFinal = $newFilename;

        // Opcional: eliminar imagen antigua (descomentar si querés borrar la vieja)
        // $old = $producto->getImagen();
        // if ($old && file_exists($uploadDir . $old)) {
        //     @unlink($uploadDir . $old);
        // }
    } else {
        // No se subió archivo nuevo: pasamos null para que edit() preserve la imagen en BD
        $imagenFinal = null;
    }

    // Ejecutar edición
    $producto->edit(
        intval($_POST['id_categoria'] ?? $producto->getIdCategoria()),
        $_POST['nombre'] ?? $producto->getNombre(),
        $_POST['presentacion'] ?? $producto->getDescripcion(),
        floatval($_POST['precio'] ?? $producto->getPrecio()),
        $imagenFinal
    );

    Alerta::add_alerta("success", "Se editó correctamente el producto: " . ($postName = ($_POST['nombre'] ?? $producto->getNombre())) . " (ID: " . $idProducto . ")");

} catch (Exception $e) {
    Alerta::add_alerta("warning", "Hubo un problema al editar el producto.");
    Alerta::add_alerta("secondary", $e->getMessage());
}

// Redirigir siempre al listado
header('Location: ../index.php?sec=productos');
exit;
