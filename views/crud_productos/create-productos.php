<?php
include('Productos.php');

// Verificando si los datos del formulario fueron recibidos
if (isset($_POST['nombre'], $_POST['precio'], $_POST['stock'], $_POST['imagen'], $_POST['categoria'])) {
    // Recibiendo los datos del formulario de manera segura
    $nombre = trim($_POST['nombre']);
    $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST['stock'], FILTER_VALIDATE_INT);
    $imagen = filter_var($_POST['imagen'], FILTER_VALIDATE_URL);
    $id_categoria = filter_var($_POST['categoria'], FILTER_VALIDATE_INT);

    // Verificando si los campos no están vacíos o inválidos
    if (empty($nombre) || $precio === false || $stock === false || $imagen === false || $id_categoria === false) {
        echo "Todos los campos son obligatorios y deben ser válidos.";
        exit;
    }

    // Creando una instancia de la clase Productos
    $productos = new Productos();

    // Llamando a la función crearProducto y verificando si la operación fue exitosa
    $resultado = $productos->crearProducto($nombre, $precio, $stock, $imagen, $id_categoria);

    if ($resultado['success']) {
        // Redirigiendo a la página principal si se guardó correctamente
        header("Location: index.php");
        exit;
    } else {
        // Mostrando un mensaje de error en caso de que falle la operación
        echo $resultado['message'];
    }
} else {
    echo "No se recibieron los datos del formulario correctamente.";
}


/*require_once 'Productos.php';

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
}*/


/*
include('Productos.php');


// Verifica que el formulario haya sido enviado correctamente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y sanitizar los datos del formulario
    $nombre = trim($_POST['nombre']);
    $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT); //Valida que el valor obtenido sea un número de tipo decimal (float).
    $stock = filter_var($_POST['stock'], FILTER_VALIDATE_INT); //Valida que el valor obtenido sea un número de tipo entero (int)
    $imagen = filter_var($_POST['imagen'], FILTER_VALIDATE_URL); //Valida que el valor obtenido sea un número de tipo url.
    $id_categoria = filter_var($_POST['categoria'], FILTER_VALIDATE_INT);

    // Validación adicional para campos obligatorios
    if (empty($nombre) || $precio === false || $stock === false || $id_categoria === false) {
        echo "Por favor, rellena todos los campos correctamente.";
        exit;
    }

    // Validar que el precio y el stock sean positivos
    if ($precio < 0 || $stock < 0) {
        echo "El precio y el stock deben ser valores positivos.";
        exit;
    }

    // Crear una instancia de la clase Productos
    $productos = new Productos();

    // Llamar al método crearProducto() para insertar los datos en la base de datos
    $resultado = $productos->crearProducto($nombre, $precio, $stock, $imagen, $id_categoria);

    if ($resultado['success']) {
        // Redirigir si el producto fue creado con éxito
        header("Location: index.php?mensaje=" . urlencode($resultado['message']));
        exit;
    } else {
        // Mostrar el mensaje de error devuelto por la clase
        echo "Error: " . htmlspecialchars($resultado['message']);
    }
} else {
    // Si el método no es POST, redirigir o mostrar un mensaje
    echo "Acceso no válido.";
}
*/

