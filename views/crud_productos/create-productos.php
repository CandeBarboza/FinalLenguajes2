<?php
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
?>


