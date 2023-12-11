<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit(); 
}
$username = $_SESSION['usuario'];
$id_usuario = $_SESSION['id_usuario'];

$url_api = "http://localhost/Proyecto_web/API_favoritos/api_favoritos_admin.php?id_usuario=$id_usuario&usuario=$username";

$curl = curl_init($url_api);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($http_status === 200) {
    $datos_favoritos = json_decode($response, true);
    if ($datos_favoritos) { // Aquí corregido
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos_user</title>
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
            Perfil de: <?php echo $username; ?>!<br>
            <h4>Mostrando las canciones añadidas a Favoritos</h4>
            <!-- Mostrar los datos de favoritos obtenidos de la API -->
            <?php if ($datos_favoritos) { ?>
                <table>
                    <tr>
                        <th>Canción</th>
                        <th>Artista</th>
                    </tr>
                    <?php foreach ($datos_favoritos as $favorito) { ?>
                        <tr>
                            <td><?php echo $favorito['Fav_nombre_cancion']; ?></td>
                            <td><?php echo $favorito['Fav_artista_cancion']; ?></td>
                        </tr>
                    <?php } ?>
                </table><br>
            <?php } else { ?>
                <p>No se encontraron datos de favoritos para mostrar.</p>
            <?php } ?>
        </div>
    </main>
    <a href="../VIEW_ADMINS/index_admin.php">Volver a Home</a>
</body>
</html>
    
<?php
    } else {
        echo "No se encontraron datos de favoritos para mostrar.";
    }
} else {
    echo "Error al obtener los datos del usuario." . $response;
}
?>
