<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit(); 
}
$username = $_SESSION['usuario'];
$id_usuario = $_SESSION['id_usuario'];

$url_api = "http://localhost/Proyecto_web/API_perfil/api_perfil_admin.php?id_usuario=$id_usuario&usuario=$username";

$curl = curl_init($url_api);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);


if ($http_status === 200) {
    $datos_usuario = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil_User</title>
</head>
<body>
    <header>
        <div class="personal_info">
            Perfil de: <?php echo $username; ?>!<br><br>
            <!-- Mostrar los datos del usuario obtenidos de la API -->
            <table border="0.5">
                <tr>
                    <th>Dato</th>
                    <th>Valor</th>
                    <th>Editar</th>
                </tr>
                <tr>
                    <td>Usuario</td>
                    <td><?php echo $datos_usuario['Usu_user']; ?></td>
                    <!-- Enlaces para editar los datos si es necesario -->
                    <td><a href='../VIEW_ADMINS/editar_perfil_admin.php?campo=Usu_user&id=<?php echo $id_usuario; ?>'>Editar</a></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><?php echo $datos_usuario['Usu_password']; ?></td>
                    <!-- Enlaces para editar los datos si es necesario -->
                    <td><a href='../VIEW_ADMINS/editar_perfil_admin.php?campo=Usu_password&id=<?php echo $id_usuario; ?>'>Editar</a></td>
                </tr>
                <tr>
                    <td>Correo</td>
                    <td><?php echo $datos_usuario['Usu_email']; ?></td>
                    <!-- Enlaces para editar los datos si es necesario -->
                    <td><a href='../VIEW_ADMINS/editar_perfil_admin.php?campo=Usu_email&id=<?php echo $id_usuario; ?>'>Editar</a></td>
                </tr>
                <tr>
                    <td>Nombre</td>
                    <td><?php echo $datos_usuario['Usu_nombre']; ?></td>
                    <!-- Enlaces para editar los datos si es necesario -->
                    <td><a href='../VIEW_ADMINS/editar_perfil_admin.php?campo=Usu_nombre&id=<?php echo $id_usuario; ?>'>Editar</a></td>
                </tr>
                <tr>
                    <td>Apellido</td>
                    <td><?php echo $datos_usuario['Usu_apellido']; ?></td>
                    <!-- Enlaces para editar los datos si es necesario -->
                    <td><a href='../VIEW_ADMINS/editar_perfil_admin.php?campo=Usu_apellido&id=<?php echo $id_usuario; ?>'>Editar</a></td>
                </tr>
                <tr>
                    <td>Fecha de creación</td>
                    <td><?php echo $datos_usuario['Usu_fechacumple']; ?></td>
                    <!-- Enlaces para editar los datos si es necesario -->
                    <td><a href='../VIEW_ADMINS/editar_perfil_admin.php?campo=Usu_fechacumple&id=<?php echo $id_usuario; ?>'>Editar</a></td>
                </tr>
            </table>
        </div>

    </header>
    <a href="../VIEW_ADMINS/index_admin.php">Volver a Home</a>
</body>
</html>
<?php
} else {
    echo "Error al obtener los datos del usuario." . $response;
}
?>
