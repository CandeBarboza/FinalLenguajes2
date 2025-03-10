<?php
include('Proveedores.php');

if (isset($_POST['id'], $_POST['nombre'], $_POST['descripcion'])) {
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);

    if (!$id || empty($nombre) || empty($descripcion)) {
        echo "Datos inválidos.";
        exit;
    }

    $proveedores = new Proveedores();
    if ($proveedores->actualizarProveedor($id, $nombre, $descripcion)) {
        header("Location: index.php?mensaje=" . urlencode("Proveedor actualizado correctamente."));
        exit;
    } else {
        echo "Error al actualizar el proveedor.";
    }
} else {
    echo "Datos incompletos.";
}


//LISTO
?>

