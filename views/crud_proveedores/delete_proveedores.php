<?php
include('Proveedores.php');

// Verificar si el ID está presente y es numérico
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $proveedores = new Proveedores();

    // Intentar eliminar el proveedor
    if ($proveedores->eliminarProveedor($id)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el proveedor.";
    }
} else {
    echo "Error: ID de proveedor inválido o no proporcionado.";
}

//LISTO
?>
