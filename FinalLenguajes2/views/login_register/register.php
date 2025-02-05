<?php
require_once dirname(__FILE__) . '/../../Database.php';
require_once dirname(__FILE__) . '/../../config.php';
require_once 'User.php';

$db = new Database();
$con = $db->getConnection();  // Usando getConnection() para obtener la conexión


$user = new User($con);  // Crea una nueva instancia de la clase 'User' y la conecta a la base de datos usando la variable $con.
$message = '';           // Inicializa una variable para almacenar mensajes de información o error (vacía al principio).
$messageType = '';       // Inicializa una variable para almacenar el tipo de mensaje ('error', 'success', etc.), vacía al principio.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Verifica si la solicitud HTTP es de tipo 'POST', es decir, si el formulario fue enviado.
    $fullname = trim($_POST['fullname']);     // Obtiene el nombre completo del usuario desde el formulario y elimina espacios extra al inicio y al final.
    $email = trim($_POST['email']);           // Obtiene el correo electrónico del formulario y elimina espacios extra.
    $username = trim($_POST['username']);     // Obtiene el nombre de usuario del formulario y elimina espacios extra.
    $password = $_POST['password'];           // Obtiene la contraseña del formulario (sin recorte de espacios).

    // Validar los datos recibidos
    if (empty($fullname) || empty($email) || empty($username) || empty($password)) {
        $message = "Por favor, completa todos los campos.";
        $messageType = "error-message";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Por favor, ingresa un correo electrónico válido.";
        $messageType = "error-message";
    } else {
        // Intentar registrar al usuario (la contraseña se encriptará dentro de register)
        $result = $user->register($fullname, $email, $username, $password);

        if ($result === true) {
            $message = "Registro exitoso. ¡Ahora puedes iniciar sesión!";
            $messageType = "success-message";
        } elseif ($result === 'duplicate_email') {
            $message = "El correo ya está registrado. Por favor, usa otro.";
            $messageType = "error-message";
        } else {
            $message = "Error al registrar. Verifica tus datos.";
            $messageType = "error-message";
        }
    }
}

include './index.php';
?>
