<?php
include('Categorias.php');

if (isset($_POST['id'], $_POST['nombre'], $_POST['descripcion'])) {
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);

    if (!$id || empty($nombre) || empty($descripcion)) {
        echo "Datos inválidos.";
        exit;
    }

    $categorias = new Categorias();
    if ($categorias->actualizarCategorias($id, $nombre, $descripcion)) {
        header("Location: index.php?mensaje=" . urlencode("Categoría actualizada correctamente."));
        exit;
    } else {
        echo "Error al actualizar la categoría.";
    }
} else {
    echo "Datos incompletos.";
}


/*
LISTO
include('Categorias.php');

// Validar si los datos necesarios están presentes en el POST
if (isset($_POST['id'], $_POST['nombre'], $_POST['descripcion'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // Validación de los datos, por ejemplo, asegurarse de que los campos no estén vacíos
    if (empty($id) || empty($nombre) || empty($descripcion)) {
        echo "Todos los campos son requeridos.";
        exit;
    }

    // Verificar que el id sea un número válido
    if (!is_numeric($id)) {
        echo "ID inválido.";
        exit;
    }

    // Crear una instancia de la clase Categorias
    $categorias = new Categorias();

    // Verificar si la categoría existe
    $categoriaExistente = $categorias->obtenerCategoriasPorId($id);
    if (!$categoriaExistente) {
        echo "La categoría no existe.";
        exit;
    }

    // Intentar actualizar la categoría
    if ($categorias->actualizarCategorias($id, $nombre, $descripcion)) {
        // Redirigir al índice después de la actualización exitosa
        header("Location: index.php");
        exit;  // Asegurarse de que el código no continúe ejecutándose después de la redirección
    } else {
        // Mostrar mensaje de error si la actualización falla
        echo "Error al actualizar la categoría";
    }
} else {
    echo "Error: Datos incompletos.";
}

*/
?>
