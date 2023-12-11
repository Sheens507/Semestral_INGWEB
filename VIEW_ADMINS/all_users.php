<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit(); 
}
$username = $_SESSION['usuario'];
$id_usuario = $_SESSION['id_usuario'];

$url_api = "http://localhost/Proyecto_web/API_admin/api_all_user.php";

$curl = curl_init($url_api);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($http_status === 200) {
    $datos_usuarios = json_decode($response, true);

    //Guardar los datos en un archivo JSON
    $json_data = json_encode($datos_usuarios, JSON_PRETTY_PRINT);
    $file_json = 'datos_usuarios.json';
    
    //Guardar los datos en un archivo TXT
    $file_txt = 'datos_usuarios.txt';
    $txt_content = '';

    foreach ($datos_usuarios as $usuario) {
        $txt_content .= "ID: " . $usuario['Usu_ID'] . "\n";
        $txt_content .= "Usuario: " . $usuario['Usu_user'] . "\n";
        $txt_content .= "E-mail: " . $usuario['Usu_email'] . "\n";
        $txt_content .= "Nombre: " . $usuario['Usu_nombre'] . "\n";
        $txt_content .= "Apellido: " . $usuario['Usu_apellido'] . "\n";
        $txt_content .= "Fecha de nacimiento o afiliación: " . $usuario['Usu_fechacumple'] . "\n";
        $txt_content .= "Tipo de usuario: " . $usuario['Usu_tipo'] . "\n\n";
    }

    if ($datos_usuarios) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver todos los usuarios</title>
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
            <h4>Mostrando todos los usuarios registrados</h4>
            <!-- Mostrar los datos de usuarios obtenidos de la API -->
            <?php if ($datos_usuarios) { ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>E-mail</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Fecha de nacimiento o afiliación</th>
                        <th>Tipo de usuario</th>
                    </tr>
                    <?php foreach ($datos_usuarios as $usuario) { ?>
                        <tr>
                            <td><?php echo $usuario['Usu_ID']; ?></td>
                            <td><?php echo $usuario['Usu_user']; ?></td>
                            <td><?php echo $usuario['Usu_email']; ?></td>
                            <td><?php echo $usuario['Usu_nombre']; ?></td>
                            <td><?php echo $usuario['Usu_apellido']; ?></td>
                            <td><?php echo $usuario['Usu_fechacumple']; ?></td>
                            <td><?php echo $usuario['Usu_tipo']; ?></td>
                        </tr>
                    <?php } ?>
                </table><br>
            <?php } else { ?>
                <p>No se encontraron datos de usuarios para mostrar.</p>
            <?php } ?>
        </div>
    </main>
    <a href="datos_usuarios.json" download>Descargar datos de usuarios en JSON</a><br><br>
    <a href="datos_usuarios.txt" download>Descargar datos de usuarios en TXT</a><br><br>
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
