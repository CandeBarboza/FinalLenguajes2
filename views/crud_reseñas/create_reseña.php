<?php
//se incluye la clase Reseña para poder crear y guardar reseñas
include('Reseña.php');

//verifica que la solicitud sea de tipo POST (evita accesos directos por URL)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //se obtienen y limpian los datos enviados por el formulario
    //trim() elimina espacios en blanco al inicio y al final del texto
    //filter_var() con FILTER_SANITIZE_STRING elimina caracteres peligrosos que puedan ser usados en ataques XSS
    $nombre = filter_var(trim($_POST['nombre']), FILTER_SANITIZE_STRING);
    $mensaje = filter_var(trim($_POST['mensaje']), FILTER_SANITIZE_STRING);
    $fecha = trim($_POST['fecha']); //no se usa filtro acá porque después se valida con strtotime()

    //validación: se verifica que ningún campo esté vacío
    if (empty($nombre) || empty($mensaje) || empty($fecha)) {
        die("❌ Error: Todos los campos son obligatorios."); //para escribir los  caracteres Unicode en Windows: presionar Win + . (teclado en español) o Win + ; (teclado en inglés) y se abre el selector de emojis y símbolos (el archivo tiene que estar guardado en formato UTF-8 para que se admitan esos caracteres)
    }

    //validación: se verifica que la fecha tenga un formato correcto
    if (!strtotime($fecha)) { //strtotime() convierte una fecha en un timestamp UNIX válido
        die("❌ Error: Fecha inválida.");
    }

    //se crea una instancia de la clase Reseña
    $reseña = new Reseña();

    //se intenta guardar la reseña
    //se asume que el método crearReseña() devuelve un array con 'success' y 'message'
    $resultado = $reseña->crearReseña($nombre, $mensaje, $fecha);

    if ($resultado['success']) {
        //si se guarda correctamente, redirigir a index.php con un mensaje de éxito
        header("Location: index.php?mensaje=" . urlencode($resultado['message']));
        exit(); //evita que el script siga ejecutándose después de la redirección
    } else {
        //si hubo un error, mostrar el mensaje devuelto por la clase Reseña
        echo "❌ Error: " . htmlspecialchars($resultado['message']);
    }
} else {
    //si alguien intenta acceder a este script directamente sin enviar un formulario POST
    echo "❌ Acceso no válido.";
}
?>


/*
include('Reseña.php');

//obtener y limpiar los datos enviados mediante un formulario POST.
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : ''; //isset verifica que se haya enviado el form y trim elimina los espacios en blanco 
$mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';
$fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : '';

// Verificar que los campos no estén vacíos
if (empty($nombre) || empty($mensaje) || empty($fecha)) {
    die("Todos los campos son obligatorios.");
}

// Asegurarse de que la fecha tenga un formato válido
if (!strtotime($fecha)) {
    die("Fecha inválida.");
}

// Crear la instancia de Reseña
$reseña = new Reseña();

// Escapar las entradas para evitar XSS
$nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
$mensaje = htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');
$fecha = htmlspecialchars($fecha, ENT_QUOTES, 'UTF-8');

// Intentar guardar la reseña
if ($reseña->crearReseña($nombre, $mensaje, $fecha)) {
    // Redirigir al usuario a la página de inicio
    header("Location: index.php");
    exit();  // Asegurarse de que no se ejecute código adicional después de la redirección
} else {
    echo "Error al crear la reseña.";
}
*/
