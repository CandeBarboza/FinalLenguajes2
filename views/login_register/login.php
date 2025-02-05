<?php
require_once dirname(__FILE__) . '/../../Database.php';
require_once dirname(__FILE__) . '/../../config.php';
include_once dirname(__FILE__) . '/../../session.php';
require_once 'User.php';


$db = new Database();
$con = $db->getConnection();  // Aquí estamos usando getConnection() para acceder a la conexión


$user = new User($con); // Crea una nueva instancia de la clase 'User', pasando la conexión a la base de datos ($con) como parámetro al constructor
$message = '';  // Inicializa una variable '$message' con un valor vacío, que se usará para almacenar mensajes de error o éxito

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica si la solicitud HTTP es de tipo 'POST'
  $email = $_POST['email']; // Obtiene el valor del campo 'email' del formulario enviado
  $password = $_POST['password']; // Obtiene el valor del campo 'password' del formulario enviado

  $loggedInUser = $user->login($email, $password); // Llama al método 'login' de la clase 'User' 

  if ($loggedInUser) { //si encuentra el usuario y las credenciale singresadas son correctas 
    session_start(); // se inicia sesion
    $_SESSION['email'] = $loggedInUser['email'];
    $_SESSION['username'] = $loggedInUser['username'];
    header('Location: ' . BASE_URL . 'index.php'); //redirige a la pagina principal
    exit;
  } else {
    $message = "Correo o contraseña incorrectos."; // Si las credenciales son incorrectas
  }
}

include './index.php';
