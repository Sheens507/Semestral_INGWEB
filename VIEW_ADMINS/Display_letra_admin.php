<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Si no hay usuario autenticado, redirigirlo a la página de inicio de sesión
    header("Location: index.php");
    exit(); // Asegurarse de que el script se detenga después de redirigir
}
$username = $_SESSION['usuario'];
?>

<?php
    function processApiResponseLetra($response_letra) {
    // Verifica si la variable $response_letra contiene datos
    if (empty($response_letra)) {
        echo "Error: Respuesta vacía";
    } else {
        // Decodifica el JSON
        $data = json_decode($response_letra, true);

        // Verifica si la decodificación fue exitosa
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Error al decodificar el JSON: " . json_last_error_msg();
        } else {
            // Accede a la información relevante
            $title = $data['lyrics']['tracking_data']['title'] ?? 'Sin título';
            $artist = $data['lyrics']['tracking_data']['primary_artist'] ?? 'Artista desconocido';
            $lyrics_html = $data['lyrics']['lyrics']['body']['html'] ?? 'No hay letra disponible';

            // Muestra la letra de la canción
            echo "<h1>$title</h1>";
            echo "<p>Artista: $artist</p>";
            echo "<div>$lyrics_html</div>";
        }
    }

    // echo "$response_letra";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="../image/icon.png" alt="logo">
        </div>
        <div class="cuenta">
            <img src="estrella.png" alt="icono">
            <div class="personal_info">
            ¡Usuario actual: <?php echo $username; ?>!<br><br>
                <a href="../VIEW_ADMINS/perfil_admin.php">Perfil</a>
                <a href="../VIEW_ADMINS/favoritos_admin.php">Favoritos</a>
                <a href="../VIEW_ADMINS/view_admin.PHP">ADMIN</a>
            </div>
        </div>
    </header>
    <nav>
        <form action="../API_canciones/call_api_admin.php" method="post" onsubmit="transformAndSubmit()">
            <input type="text" name="nombre" id="nombre" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
            <input type="submit" value="Enviar">
        </form>
    </nav>

    <section>
        <div class="display">
        <?php
            processApiResponseLetra($response_letra);
        ?>
        </div>
        <!-- de aqui para abajo se puede borrar like X -->
    </section>
    <a href="../VIEW_ADMINS/Display_info_admin.php">Volver</a>
    <footer>
        <p>footer de toda la vida</p>
    </footer>
</body>
</html>
<!--  