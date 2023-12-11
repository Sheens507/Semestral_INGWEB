
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
        <nav>
            <ul>
                <li><a href="../Login.php">Login</a></li>
                <li><a href="../Registro.php">Sign Up</a></li>
            </ul>
        </nav>
    </header>
    <nav>
        <form action="../API_canciones/call_api.php" method="post" onsubmit="transformAndSubmit()">
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
    </section>
    <a href="../index.php">Volver al Index</a>
    <footer>
        <p>footer de toda la vida</p>
    </footer>
</body>
</html>
<!--  