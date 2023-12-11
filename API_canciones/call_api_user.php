<?php
session_start();

// Obtiene el nombre de usuario de la sesión
if (isset($_SESSION['usuario'])) {
    $username = $_SESSION['usuario'];

    // Obtiene el nombre de la canción desde el formulario
    $song = isset($_POST['nombre']) ? $_POST['nombre'] : '';

    // Establece el nombre de la canción con el usuario
    $cookieName = "ultima_cancion_" . $username;

    if (!empty($song)) {
        setcookie($cookieName, $song, time() + (86400 * 1), "/");
    }

    // Llamada a la API de Genius para obtener información de la canción
    $curl = curl_init();
    $url = "https://genius-song-lyrics1.p.rapidapi.com/search/?q=" . urlencode($song) . "&per_page=6&page=1";
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: genius-song-lyrics1.p.rapidapi.com",
            "X-RapidAPI-Key: 5ab8f2c36amshc6d09b3d9de7172p1ac2c9jsn1b2fca3fdb3b"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        // Procesar la respuesta de la API
        include('../VIEW_USERS/Display_info_users.php');
        processApiResponse($response);

        // Llamada al procedimiento Insertar_busqueda en la base de datos
        $conexion = new mysqli("localhost", "root", "", "prueba");
        if ($conexion->connect_error) {
            die("Error en la conexión: " . $conexion->connect_error);
        }

        $nombre_cancion = $song;
        $query = "CALL Insertar_busqueda('$nombre_cancion')";
        $conexion->query($query);

        $conexion->close();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/Proyecto_web/styles/styles.css">
    <title>Tu Título Aquí</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }

        .logo img {
            width: 30px;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #ffffff;
            color: #000000;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #000000;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 1px;
            transition: 0.5s;
        }

        .cuenta {
            display: flex;
            align-items: center;
        }

        .cuenta img {
            width: 35px;
            height: auto;
            margin-left: 10px;
        }

        .personal_info {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

        nav ul li a.btn-login {
            background-color: #2a2a2a;
            color: #fff;
            padding: 10px 20px;
            border-radius: 30px;
            transition: 0.5s;
        }

        nav ul li a.btn-login:hover {
            background-color: #1c1c1c;
        }

        a:hover {
            text-decoration: underline;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .song-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #fff;
        }

        .song-item-img img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <div class="logo">
            <img src="../image/icon.png" alt="logo">
        </div>
        <nav>
            <ul>
                <li><a href="#">Enlace1</a></li>
                <li><a href="#">Enlace2</a></li>
            </ul>
        </nav>
        <div class="cuenta">
            <img src="estrella.png" alt="icono">
            <div class="personal_info">
                ¡Hola <?php echo $username; ?>!<br><br>
                <a href="../VIEW_USERS/perfil_user.php">Perfil</a>
                <a href="../VIEW_USERS/favoritos_user.php">Favoritos</a>
            </div>
        </div>
    </div>

    <?php
        // Procesar la respuesta de la API para mostrar las canciones
        $songs = json_decode($response, true);

        // Verificamos si $songs es un array válido antes de intentar iterar sobre él
        if (isset($songs['hits']) && is_array($songs['hits'])) {
    ?>
        <div class="grid-container">
            <?php
            foreach ($songs['hits'] as $hit) {
                $result = $hit['result'];
            ?>
                <div class="song-item">
                    <div class="song-item-img">
                        <img src="<?php echo $result['header_image_url']; ?>" alt="<?php echo $result['title_with_featured']; ?>" style="max-width: 100%; height: auto; border-radius: 4px;">
                    </div>
                    <h3><?php echo $result['title_with_featured']; ?></h3>
                    <p><b>Artist:</b> <?php echo $result['primary_artist']['name']; ?></p>

                    <?php
                    if (isset($result['featured_artists']) && is_array($result['featured_artists'])) {
                        echo '<p><b>Featured Artists:</b> ';
                        $featuredArtists = array_map(function ($artist) {
                            return $artist['name'];
                        }, $result['featured_artists']);
                        echo implode(', ', $featuredArtists) . '</p>';
                    } else {
                        echo "<p><b>Featured Artists:</b> null</p>";
                    }
                    ?>

                    <button onclick="mostrarLetras('<?php echo htmlspecialchars($result['letras_url']); ?>')">Ver Letras</button>
                    <button onclick="agregarFavorito('<?php echo $result['title_with_featured']; ?>')">Agregar a Favoritos</button>
                </div>
            <?php
            }
            ?>
        </div>
    <?php
        } else {
            // Manejar el caso donde $songs no es un array válido
            echo "Error: La respuesta no tiene el formato esperado.";
        }
    ?>
</body>
</html>
<?php
} else {
    // Redirigir si el usuario no está autenticado
    header("Location: index.php");
    exit();
}
?>