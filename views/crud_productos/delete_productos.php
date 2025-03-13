<?php
include('Productos.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $productos = new Productos();
    
    if ($productos->eliminarProducto($id)) {
        header("Location: index.php"); // Solo redirige sin mensajes
        exit;
    } else {
        echo "Error al eliminar el producto.";
    }
} else {
    echo "ID de producto no válido.";
}

//LISTO
?>
