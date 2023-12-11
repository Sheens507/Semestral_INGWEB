<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Si no hay usuario autenticado, redirigirlo a la página de inicio de sesión
    header("Location: index.php");
    exit(); // Asegurarse de que el script se detenga después de redirigir
}
$username = $_SESSION['usuario'];
$id_usuario = $_SESSION['id_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home_Admin</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../image/icon.png" alt="logo">
        </div>
        <div class="cuenta">
            <img src="estrella.png" alt="icono">
            <div class="personal_info">
            ¡Hola <?php echo $username; ?>!<br><br>
                <a href="../VIEW_ADMINS/perfil_admin.php">Perfil</a>
                <a href="../VIEW_ADMINS/favoritos_admin.php">Favoritos</a>
                <a href="view_admin.PHP">ADMIN</a>
            </div>
            
        </div>
    </header>
    <form action="../API_canciones/call_api_admin.php" method="post" onsubmit="transformAndSubmit()">
        <input type="text" name="nombre" id="nombre" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
        <input type="submit" value="Enviar"><br><br>
    </form>
    <?php
            //Aquí se obtiene el valor de la última canción buscada por cada usuario
            $cookieName = "ultima_cancion_" . $username;
            $ultima_Cancion = isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : '';

            //Muestra la info de la última canción buscada
            if (!empty($ultima_Cancion)) {
                echo 'Última canción buscada: ' . htmlspecialchars($ultima_Cancion) . '<br><br>';
            } else {
                echo 'No se ha buscado ninguna canción recientemente.<br><br>';
            }
            ?>

            <!--Muestra la última canción guardada en fqavoritos-->
            <?php
            //Se obtiene el valor de la cookie basado en el ID de usuario de la sesión
            $cookieName = "favorito_" . $id_usuario;

            if (isset($_COOKIE[$cookieName])) {
            $favorito = json_decode($_COOKIE[$cookieName], true);
            //Se accede a los valores de la cookie
            echo "Última canción añadida a favoritos:<br>";
            echo "Nombre de la canción: " . $favorito['nombre_cancion'] . "<br>";
            echo "Nombre del artista: " . $favorito['nombre_artista'] . "<br><br>";
            } else {
            echo "No se ha añadido ninguna canción a favoritos recientemente. <br>";
            }
            ?>

            <?php
            //Muestra las busquedas recientes de todos los usuarios
            include('../busqueda.php');
            $datos = obtenerDatosBusqueda();

            if (isset($datos['error'])) {
            echo "Error: " . $datos['error'];
            } elseif (isset($datos['message'])) {
            echo "Mensaje: " . $datos['message'];
            } else {
            echo "Top 10: canciones más buscadas";
            echo "<ul>";
            foreach ($datos as $busqueda) {
            echo "<li>" . $busqueda['Bus_nombre'] . "</li>";
            }
            echo "</ul>";
            }
            ?>
    <form action="../cerrar_sesion.php" method="post"> <!--Este form es para poder cerrar la sesión-->
    <button type="submit" name="cerrar_sesion">Cerrar Sesión</button>
</form>
</body>
</html>