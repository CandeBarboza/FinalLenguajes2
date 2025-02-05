<?php
include('Proveedores.php');

//Verificar si la solicitud es del tipo POST y si los datos necesarios están presentes en el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && 
    isset($_POST['id'], $_POST['nombre_proveedores'], $_POST['razon_social'])) {
    
    // Obtener y sanitizar los datos
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT); // Validar que el ID sea un número entero
    $nombre_proveedores = trim($_POST['nombre_proveedores']); // Eliminar espacios en blanco antes y después del nombre
    $razon_social = trim($_POST['razon_social']); // Eliminar espacios en blanco antes y después de la razón social

    // Validar que los campos sean válidos y no esten vacios 
    if (!$id || empty($nombre_proveedores) || empty($razon_social)) {
        echo "Datos inválidos. Por favor, revisa los campos.";
        exit;
    }

    // Crear una instancia de la clase Proveedores
    $proveedores = new Proveedores();

    // Intentar actualizar el proveedor
    if ($proveedores->actualizarProveedor($id, $nombre_proveedores, $razon_social)) {
        // Redirigir con un mensaje de éxito
        header("Location: index.php?mensaje=" . urlencode("Proveedor actualizado correctamente."));
        exit; // Salir después de la redirección
    } else {
        echo "Error al actualizar el proveedor. Intenta nuevamente.";
    }
} else {
    echo "Solicitud no válida o faltan datos.";
}
?>

