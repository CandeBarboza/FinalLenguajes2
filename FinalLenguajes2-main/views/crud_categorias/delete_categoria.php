<?php
include('Categorias.php');

// Verificar si 'id' está presente en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $categorias = new Categorias();

    // Intentar eliminar la categoría
    if ($categorias->eliminarCategorias($id)) {
        header("Location: index.php");
        exit; // Asegurarse de que el código no siga ejecutándose después de la redirección
    } else {
        echo "Error: No se pudo eliminar la categoría.";
    }
} else {
    echo "Error: ID de categoría inválido o no proporcionado.";
}
?>
