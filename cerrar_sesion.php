<?php
session_start();

// Verificar si se ha enviado el formulario para cerrar sesión
if (isset($_POST['cerrar_sesion'])) {
    // Eliminar todas las variables de sesión
    $_SESSION = array();

    // Finalizar la sesión
    session_destroy();

    // Redirigir a la página de inicio de sesión después de cerrar sesión
    header("Location: index.php");
    exit();
}

