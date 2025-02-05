<?php
if (session_status() === PHP_SESSION_NONE) { // Verifica si no se ha iniciado una sesión
    session_start(); // Inicia la sesión si aún no ha sido iniciada
}
?>
