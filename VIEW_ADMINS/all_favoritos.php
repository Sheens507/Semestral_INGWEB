<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit(); 
}
$username = $_SESSION['usuario'];
$id_usuario = $_SESSION['id_usuario'];

$url_api = "http://localhost/Proyecto_web/API_admin/api_all_favoritos.php";

$curl = curl_init($url_api);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($http_status === 200) {
    $datos_favoritos = json_decode($response, true);

    // Guardar en un archivo JSON
    $json_data = json_encode($datos_favoritos, JSON_PRETTY_PRINT);
    file_put_contents('datos_favoritos.json', $json_data);

    // Guardar en un archivo de texto (TXT)
    $txt_data = '';
    foreach ($datos_favoritos as $dato) {
        $txt_data .= "Canción: " . $dato['Fav_nombre_cancion'] . "\n";
        $txt_data .= "Artista: " . $dato['Fav_artista_cancion'] . "\n"; 
        $txt_data .= "Usuario: " . $dato['Usu_user'] . "\n\n";
    }
    file_put_contents('datos_favoritos.txt', $txt_data);

    if ($datos_favoritos) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver todos los favoritos</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
        }

        th, td {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <main>
        <div class="personal_info">
            Administrador: <?php echo $username; ?>!<br>
            <h4>Mostrando todos los favoritos registrados</h4>
            <!-- Mostrar los datos de favoritos obtenidos de la API -->
            <?php if ($datos_favoritos) { ?>
                <table>
                    <tr>
                        <th>Nombre de la canción</th>
                        <th>Artista</th>
                        <th>Usuario que guardó la canción</th>
                    </tr>
                    <?php foreach ($datos_favoritos as $favorito) { ?>
                        <tr>
                            <td><?php echo $favorito['Fav_nombre_cancion']; ?></td>
                            <td><?php echo $favorito['Fav_artista_cancion']; ?></td>
                            <td><?php echo $favorito['Usu_user']; ?></td>
                        </tr>
                    <?php } ?>
                </table><br>
            <?php } else { ?>
                <p>No se encontraron datos de favoritos para mostrar.</p>
            <?php } ?>
        </div>
    </main>
    <a href="datos_favoritos.json" download>Descargar datos de usuarios en JSON</a><br><br>
    <a href="datos_favoritos.txt" download>Descargar datos de usuarios en TXT</a><br><br>
    <a href="../VIEW_ADMINS/index_admin.php">Volver a Home</a>
</body>
</html>
    
<?php
    } else {
        echo "No se encontraron datos de usuarios para mostrar.";
    }
} else {
    echo "Error al obtener los datos de usuarios: " . $response;
}
?>
