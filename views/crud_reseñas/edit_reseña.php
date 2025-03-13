<?php
include('Reseña.php');

if (isset($_POST['id'], $_POST['nombre'], $_POST['mensaje'], $_POST['fecha'])) {
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $nombre = trim($_POST['nombre']);
    $mensaje = trim($_POST['mensaje']);
    $fecha = trim($_POST['fecha']);

    if (!$id || empty($nombre) || empty($mensaje)|| empty($fecha)) {
        echo "Datos inválidos.";
        exit;
    }

    $reseña = new Reseña();
    if ($reseña->actualizarReseña($id, $nombre, $mensaje, $fecha)) {
        header("Location: index.php?mensaje=" . urlencode("Reseña actualizada correctamente."));
        exit;
    } else {
        echo "Error al actualizar la reseña.";
    }
} else {
    echo "Datos incompletos.";
}

//LISTO
?>
