<?php


// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Si no hay usuario autenticado, redirigirlo a la página de inicio de sesión
    header("Location: index.php");
    exit(); // Asegurarse de que el script se detenga después de redirigir
}
$username = $_SESSION['usuario'];
$id_usuario = $_SESSION['id_usuario'];
?>

<?php
    function processApiResponse($response) {
        $data = json_decode($response, true);
        foreach ($data['hits'] as $hit) {
            $result = $hit['result'];
            $id = $result['id'];
            $title_with_featured = $result['title_with_featured'];
            $header_image_url = $result['header_image_url'];
            $primary_artist_name = $result['primary_artist']['name'];
    
            echo '<div class="container">';
            echo '<img src="' . $header_image_url . '" alt="Banner ' . $title_with_featured . '">';
            echo '<div class="contenido">';
            echo '<div class="info">';
            echo '<h2>' . $title_with_featured . '</h3>';
            echo '<p><b>Artist:</b> ' . $primary_artist_name . '</p>';
    
            if (isset($result['featured_artists']) && is_array($result['featured_artists'])) {
                echo '<p><b>Featured Artists:</b> ';
                $featuredArtists = array_map(function ($artist) {
                    return $artist['name'];
                }, $result['featured_artists']);
                echo implode(', ', $featuredArtists) . '</p>';
            } else {
                echo "<p><b>Featured Artists:</b> null</p>";
            }
    
            echo '<div class="botones">';
            echo '<form action="../API letras/call_api_letra_user.php" method="post">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<button type="submit">Lyrics</button>';
            echo '</form>';
            echo '</div>'; // Cierre de div.botones
    
            echo '<div class="botones">';
            echo '<form action="../VIEW_USERS/guardar_favorito.php" method="post">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<input type="hidden" name="imagen_cancion" value="' . $header_image_url . ' ">';
            echo '<input type="hidden" name="nombre_cancion" value="' . $title_with_featured . '">';
            echo '<input type="hidden" name="nombre_artista" value="' . $primary_artist_name . '">';
            echo '<button type="submit">Favoritos</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
    
            $count++;
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canciones</title>
    <link href="../styles/style.css" rel="stylesheet">
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
    <h1>Resultados:</h1>
        <div class="contenido">
        <div class="display">
        <?php
            processApiResponse($response);
        ?>
        </div>
    </div>
    <a href="../VIEW_ADMINS/index_admin.php">Volver</a>
    <footer>
        <p>footer de toda la vida</p>
    </footer>
</body>
</html>
<!--  