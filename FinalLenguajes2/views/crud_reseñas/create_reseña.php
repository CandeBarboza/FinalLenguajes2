<?php
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
?>
