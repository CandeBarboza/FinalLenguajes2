<?php
include('Proveedores.php');

// Verificar que el ID esté presente en la URL
if (empty($_GET['id'])) { //Se verifica si el parámetro id está vacío o no ha sido enviado en la URL.
    echo "ID del proveedor no especificado.";
    exit;
}

// Obtener el ID y verificar que sea numérico
$id = $_GET['id'];
if (!is_numeric($id)) {
    echo "ID inválido.";
    exit;
}

try {
    $proveedores = new Proveedores();
    
    // Verificar si el proveedor existe antes de eliminarlo
    $proveedor = $proveedores->obtenerProveedorPorId($id);
    if (!$proveedor) {
        echo "Proveedor no encontrado.";
        exit;
    }

    // Intentar eliminar el proveedor con el ID proporcionado
    if ($proveedores->eliminarProveedor($id)) {
        // Redirigir a la página principal con un mensaje de éxito
        header("Location: index.php?message=Proveedor eliminado correctamente");
        exit;
    } else {
        throw new Exception("Error al eliminar proveedor.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
