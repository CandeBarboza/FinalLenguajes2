<?php
include('Reseña.php');
require_once dirname(__FILE__) . '/../../config.php';

// Verificar si el parámetro 'id' está presente y es un número válido
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    // Si 'id' no es válido, redirigir con un error
    header("Location:" . BASE_URL . "views/crud_reseñas/index.php?error=invalid_id");
    exit();
}

$reseña = new Reseña();

try {
    // Intentar eliminar la reseña
    if ($reseña->eliminarReseña($id)) {
        // Redirigir con éxito
        header("Location:" . BASE_URL . "views/crud_reseñas/index.php?success=1");
    } else {
        // Si no se pudo eliminar, redirigir con error
        header("Location:" . BASE_URL . "views/crud_reseñas/index.php?error=1");
    }
} catch (mysqli_sql_exception $e) { // Capturar errores específicos de MySQL (por ejemplo, claves foráneas, restricciones, etc.).
    // Capturar errores de SQL específicos y redirigir con un mensaje adecuado
    header("Location:" . BASE_URL . "views/crud_reseñas/index.php?error=foreign_key"); // Se añade "?error=foreign_key" para indicar que hubo un problema con una clave foránea.
    exit();
}
?>
