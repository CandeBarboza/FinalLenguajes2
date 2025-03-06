<?php
include('Categorias.php');

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

    // Crear una nueva instancia de Categorias y agregar la categoría
    $categorias = new Categorias();

    if (!$categorias->crearCategorias($nombre, $descripcion)) {
        throw new Exception("Error al crear la categoría.");
    }

    // Redirigir si se creó con éxito
    header("Location: index.php");
    exit;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

/*
include('Categorias.php');

// Verificando si los datos del formulario fueron recibidos
if (isset($_POST['nombre']) && isset($_POST['descripcion'])) {
    // Recibiendo los datos del formulario de manera segura
    $nombre = trim($_POST['nombre']); //trim elimina espacios en blanco 
    $descripcion = trim($_POST['descripcion']);

    // Verificando si los campos no están vacíos
    if (empty($nombre) || empty($descripcion)) { 
        echo "Los campos nombre y descripción son obligatorios.";
        exit;
    }

    // Creando una instancia de la clase Categorias
    $categorias = new Categorias();

    // Llamando a la función crearCategorias y verificando si la creación fue exitosa
    if ($categorias->crearCategorias($nombre, $descripcion)) {
        // Redirigiendo a la página principal si se creó la categoría
        header("Location: index.php");
        exit; 
    } else {
        // Mostrando un mensaje de error en caso de que la creación falle
        echo "Error al crear la categoría.";
    }
} else {
    echo "No se recibieron los datos del formulario correctamente.";
}
*/

?>
