<?php
require_once __DIR__ . '/../../functions/autoload.php';

$postData = $_POST;
$imagenNombre = null;

try {
    // Validaciones básicas
    if (empty($postData['categoria'])) {
        throw new Exception("Faltan datos obligatorios.");
    }

// Procesar subida de imagen si existe
if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $allowed = ['jpg','jpeg','png','gif'];
    $tmp = $_FILES['foto']['tmp_name'];
    $origName = $_FILES['foto']['name'];
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    if (in_array($ext, $allowed)) {
        // Generar nombre único y seguro
        $safeBase = preg_replace('/[^a-z0-9_\-]/i', '_', pathinfo($origName, PATHINFO_FILENAME));
        $imagenNombre = $safeBase . '_' . time() . '.' . $ext;

        $uploadDir = __DIR__ . '/../../assets/imagenes/categorias-fotitos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $dest = $uploadDir . $imagenNombre;
        if (!move_uploaded_file($tmp, $dest)) {
            // Si falla mover, limpiar variable para que no se guarde un valor inválido
            $imagenNombre = null;
        }
    } else {
        // Extensión no permitida: opcionalmente manejar error
        $imagenNombre = null;
    }
} else {
    // No se subió archivo: puedes tomar imagen_og si viene desde formulario o dejar null
    $imagenNombre = $_POST['imagen_og'] ?? null;
}

// Llamar al método que inserta la categoría (ajusta según firma real)
if ($imagenNombre !== null) {
    Categoria::insert(
        $postData['categoria'],
        $imagen
    );
} else {
    Categoria::insert(
        $postData['categoria']
    );
}

    Alerta::add_alerta("success", "Se creó correctamente la categoría: " . $postData['categoria'] . " (ID: " . $postData['id'] . ")");

} catch (Exception $e) {
    die("No se pudo cargar la categoría: " . $e->getMessage());
}

header('Location: ../index.php?sec=categorias');
exit;




