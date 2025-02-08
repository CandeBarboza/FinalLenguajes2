<?php
require_once 'Productos.php';

//verifica que el formulario haya sido enviado correctamente mediante el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //obtener y sanitizar los datos del formulario
    $nombre = trim($_POST['nombre'] ?? ''); //si no existe la clave 'nombre', se asigna una cadena vacía
    $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT); //valida que el precio sea un número decimal
    $stock = filter_var($_POST['stock'], FILTER_VALIDATE_INT); //valida que el stock sea un número entero
    $imagen = filter_var($_POST['imagen'], FILTER_VALIDATE_URL); //valida que la imagen sea una url válida
    $id_categoria = filter_var($_POST['categoria'], FILTER_VALIDATE_INT); //valida que la categoría sea un número entero

    //validación de campos obligatorios, si alguno es inválido o no existe, redirige con un mensaje de error
    if (empty($nombre) || $precio === false || $stock === false || $imagen === false || $id_categoria === false) {
        header("Location: index.php?error=" . urlencode("Por favor, rellena todos los campos correctamente."));
        exit;
    }

    //validar que el precio y el stock sean valores positivos
    if ($precio < 0 || $stock < 0) {
        header("Location: index.php?error=" . urlencode("El precio y el stock deben ser valores positivos."));
        exit;
    }

    //crear una instancia de la clase Productos para interactuar con la base de datos
    $productos = new Productos();

    //verificar que la categoría existe antes de crear el producto
    if (!$productos->categoriaExiste($id_categoria)) {
        header("Location: index.php?error=" . urlencode("La categoría seleccionada no existe."));
        exit;
    }

    //llamar al método crearProducto() para insertar los datos en la base de datos
    $resultado = $productos->crearProducto($nombre, $precio, $stock, $imagen, $id_categoria);

    //si la inserción fue exitosa, redirige con un mensaje de éxito, si no, con un mensaje de error
    if ($resultado['success']) {
        header("Location: index.php?mensaje=" . urlencode($resultado['message']));
        exit;
    } else {
        header("Location: index.php?error=" . urlencode($resultado['message']));
        exit;
    }
} else {
    //si el acceso al script no es mediante POST, redirige con un mensaje de error
    header("Location: index.php?error=" . urlencode("Acceso no válido."));
    exit;
}

