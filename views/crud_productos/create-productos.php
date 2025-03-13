<?php
include('Productos.php');

try {

    // Creando una instancia de la clase Productos
    $productos = new Productos();

    // Verificar si los datos fueron enviados
    if (!isset($_POST['nombre']) || !isset($_POST['precio']) || !isset($_POST['stock']) || !isset($_POST['tipo_envase']) || !isset($_POST['imagen_url']) || !isset($_POST['id_categoria'])) {
        throw new Exception("No se recibieron los datos del formulario correctamente.");
    }
    $nombre = trim(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING));
    $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST['stock'], FILTER_VALIDATE_INT);
    $tipo_envase = trim(filter_var($_POST['tipo_envase'], FILTER_SANITIZE_STRING));
    $imagen_url = filter_var($_POST['imagen_url'], FILTER_VALIDATE_URL);
    $id_categoria = filter_var($_POST['id_categoria'], FILTER_VALIDATE_INT);

    // Verificando si los campos no están vacíos o inválidos
    if (empty($nombre) || $precio === false || $stock === false || empty($tipo_envase) || $imagen_url === false || $id_categoria === false) {
        echo "Todos los campos son obligatorios y deben ser válidos.";
        exit;
    }

    // Validar que el precio y el stock sean positivos
    if ($precio < 0 || $stock < 0) {
        echo "El precio y el stock deben ser valores positivos.";
        exit;
    }

    if (!$productos->crearProducto($nombre, $precio, $stock, $tipo_envase, $imagen_url, $id_categoria)) {
        throw new Exception("Error al crear el producto.");
    }

    // Redirigir si se creó con éxito
    header("Location: index.php");
    exit;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

