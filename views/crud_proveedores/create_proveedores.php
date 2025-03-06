<?php
include('Proveedores.php');

try {
    // Verificar si los datos fueron enviados
    if (!isset($_POST['nombre']) || !isset($_POST['descripcion'])) {
        throw new Exception("No se recibieron los datos del formulario correctamente.");
    }

    // Sanitizar y validar las entradas del formulario
    $nombre = trim(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
    $descripcion = trim(filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING));

    // Verificar que los campos no estén vacíos
    if (empty($nombre) || empty($descripcion)) {
        throw new Exception("Los campos Nombre y Descripción son obligatorios.");
    }

    // Crear una nueva instancia de Proveedores y agregar el proveedor
    $proveedores = new Proveedores();

    if (!$proveedores->crearProveedor($nombre, $descripcion)) {
        throw new Exception("Error al crear el proveedor.");
    }

    // Redirigir si se creó con éxito
    header("Location: index.php");
    exit;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

/*
LISTO
include('Proveedores.php');

// Sanitizar y validar las entradas del formulario
$nombre_proveedores = filter_var($_POST['nombre_proveedores'], FILTER_SANITIZE_STRING); // Limpia la entrada eliminando caracteres especiales
$razon_social = filter_var($_POST['razon_social'], FILTER_SANITIZE_STRING);

// Verificar que los campos no estén vacíos
if (empty($nombre_proveedores) || empty($razon_social)) {
    echo "Los campos Nombre del Proveedor y Razón Social son obligatorios.";
    exit;
}

try {
    // Crear un nuevo objeto Proveedores y agregar el proveedor
    $proveedores = new Proveedores();
    if ($proveedores->crearProveedor($nombre_proveedores, $razon_social)) {
        header("Location: index.php"); // Redirige al usuario a la página principal si la creación fue exitosa
        exit;
    } else {
        throw new Exception("Error al crear proveedor.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
*/

?>
