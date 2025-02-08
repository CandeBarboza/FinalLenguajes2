<?php
include('Reseña.php');

// Asegurarnos de que todas las variables sean correctas
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$mensaje = $_POST['mensaje']; 
$fecha = $_POST['fecha'];  

// Crear una instancia de la clase Reseña
$reseña = new Reseña();

// Intentar actualizar la reseña con los datos obtenidos
if ($reseña->actualizarReseña($id, $nombre, $mensaje, $fecha)) {
    header("Location: index.php");  // Redirigir en caso de éxito
} else {
    echo "Error al actualizar la reseña";  // Mostrar mensaje de error si la actualización falla
}
?>
