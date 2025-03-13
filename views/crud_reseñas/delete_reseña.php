<?php
include('Reseña.php');

// Verificar si el ID está presente y es numérico
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $reseña = new Reseña();

    // Intentar eliminar el proveedor
    if ($reseña->eliminarReseña($id)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar la reseña.";
    }
} else {
    echo "Error: ID de reseña inválido o no proporcionado.";
}

//LISTO

?>
