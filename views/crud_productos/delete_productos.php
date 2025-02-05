<?php
include('Productos.php');

// Verificar si el parámetro 'id' está presente y es un número
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $id = $_GET['id'];

    // Instanciar la clase Productos
    $productos = new Productos();

    // Intentar eliminar el producto
    if ($productos->eliminarProducto($id)) {
        // Redirigir con un mensaje de éxito
        header("Location: index.php?mensaje=" . urlencode("Producto eliminado correctamente."));
        exit; // Salir después de la redirección
    } else {
        // Mostrar un mensaje de error si la eliminación falla
        echo "Error al eliminar el producto. Por favor, intenta nuevamente.";
    }
} else {
    // Mensaje para un ID no válido
    echo "ID de producto no válido.";
}
?>
