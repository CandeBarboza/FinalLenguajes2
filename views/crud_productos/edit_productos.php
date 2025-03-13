<?php
include('Productos.php');

// Verificar si los datos necesarios están presentes
if (isset($_POST['id'], $_POST['nombre'], $_POST['precio'], $_POST['stock'], $_POST['tipo_envase'], $_POST['imagen'], $_POST['id_categoria'])) {
    
    // Obtener y sanitizar los datos
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $nombre = trim($_POST['nombre']);
    $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST['stock'], FILTER_VALIDATE_INT);
    $tipo_envase = filter_var($_POST['tipo_envase'], FILTER_VALIDATE_INT);
    $imagen_url = filter_var($_POST['imagen'], FILTER_VALIDATE_URL);
    $id_categoria = filter_var($_POST['id_categoria'], FILTER_VALIDATE_INT);

    // Validar que los campos sean válidos
    if (!$id || !$precio || !$stock || !$tipo_envase || !$imagen_url || !$id_categoria || empty($nombre)) {
        echo "Datos inválidos. Por favor, revisa los campos.";
        exit;
    }

    // Crear una instancia de la clase Productos
    $productos = new Productos();

    // Intentar actualizar el producto
    if ($productos->actualizarProducto($id, $nombre, $precio, $stock, $tipo_envase, $imagen_url, $id_categoria)) {
        // Redirigir con un mensaje de éxito
        header("Location: index.php?mensaje=" . urlencode("Producto actualizado correctamente."));
        exit; // Salir después de la redirección
    } else {
        echo "Error al actualizar el producto.";
    }
} else {
    echo "Solicitud no válida o faltan datos.";
}

//LISTO
?>
