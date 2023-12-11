<?php
session_start();

// Verificar si se ha enviado un ID de usuario
$id_usuario = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($id_usuario !== null) {
        // Datos de conexión
        $nombreservidor = "localhost";
        $nombreusuario = "root";
        $password = "";
        $basedatos = "prueba";

        // Estableciendo conexión con la BD
        $conn = new mysqli($nombreservidor, $nombreusuario, $password, $basedatos);

        $mensaje = $mensajeExito = $mensajeError = "";

        // obteniendo los datos del formulario
        $nuevo_usuario = $_POST['nuevo_usuario'];

        // Validación y escape para prevenir inyección SQL
        $nuevo_usuario = mysqli_real_escape_string($conn, $nuevo_usuario);

        // Consulta SQL para obtener el nombre de usuario actual
        $query = "SELECT Usu_user FROM usuario WHERE Usu_ID = $id_usuario";
        $result = $conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nombre_usuario_actual = $row['Usu_user'];

            if ($nombre_usuario_actual == $nuevo_usuario) {
                $mensaje = "El nuevo usuario no puede ser igual al anterior";
            } else {
                // Llamando al procedimiento almacenado para actualizar el usuario
                $procedure = $conn->prepare("CALL actualizar_user(?, ?)");
                $procedure->bind_param("ss", $id_usuario, $nuevo_usuario);

                // Ejecutando el procedimiento
                if ($procedure->execute()) {
                    $mensajeExito = "Actualización exitosa";
                } else {
                    $mensajeError = "Error al actualizar el usuario: " . $conn->error;
                }
                $procedure->close();
            }
        } else {
            $mensajeError = "No se encontró el usuario con el ID proporcionado.";
        }
    } else {
        $mensajeError = "No se proporcionó un ID de usuario válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta</title>
</head>
<body>
    <?php
    // Si es un mensaje de registro exitoso
    if (!empty($mensajeExito)) {
        echo "<p>$mensajeExito</p>";
        echo '<a href="../../index.php">Volver a iniciar sesión</a>';
    }
    // Si es un mensaje de error
    elseif (!empty($mensaje) || !empty($mensajeError)) {
        echo "<p>" . (!empty($mensaje) ? $mensaje : $mensajeError) . "</p>";
        echo '<a href="../../VIEW_USERS/perfil_admin.php">Volver al perfil</a>';
    }
    ?>
</body>
</html>
