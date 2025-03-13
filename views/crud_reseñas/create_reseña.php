<?php
include('Reseña.php');

try {
    // Verificar si los datos fueron enviados
    if (!isset($_POST['nombre']) || !isset($_POST['mensaje']) || !isset($_POST['fecha'])) {
        throw new Exception("No se recibieron los datos del formulario correctamente.");
    }
    
    // Sanitizar y validar las entradas del formulario
    $nombre = trim(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
    $mensaje = trim(filter_var($_POST['mensaje'], FILTER_SANITIZE_STRING));
    $fecha = trim(filter_var($_POST['fecha'], FILTER_SANITIZE_STRING));

    // Verificar que los campos no estén vacíos
    if (empty($nombre) || empty($mensaje) || empty($fecha)) {
        throw new Exception("Los campos Nombre, Mensaje y Fecha son obligatorios.");
    }


    //validación: se verifica que la fecha tenga un formato correcto
    if (!strtotime($fecha)) { //strtotime() convierte una fecha en un timestamp UNIX válido
        throw new Exception("Error: Fecha inválida.");
    }

    //se crea una instancia de la clase Reseña
    $reseña = new Reseña();

    if (!$reseña->crearReseña($nombre, $mensaje, $fecha)) {
        throw new Exception("Error al crear la reseña.");
    }

    // Redirigir si se creó con éxito
    header("Location: index.php");
    exit;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

//LISTO

?>


