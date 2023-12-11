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
        $nueva_fecha = $_POST['nueva_fecha'];

        // Validación y escape para prevenir inyección SQL
        $nueva_fecha = mysqli_real_escape_string($conn, $nueva_fecha);

        // Consulta SQL para obtener el nombre de usuario actual
        $query = "SELECT Usu_fechacumple FROM usuario WHERE Usu_ID = $id_usuario";
        $result = $conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $fecha_actual = $row['Usu_fechacumple'];

            if ($fecha_actual == $nueva_fecha) {
                $mensaje = "La fecha nueva no puede ser igual al anterior";
            } else {
                // Llamando al procedimiento almacenado para actualizar el usuario
                $procedure = $conn->prepare("CALL actualizar_fecha(?, ?)");
                $procedure->bind_param("ss", $id_usuario, $nueva_fecha);

                // Ejecutando el procedimiento
                if ($procedure->execute()) {
                    $mensajeExito = "Actualización exitosa";
                } else {
                    $mensajeError = "Error al actualizar el nombre: " . $conn->error;
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
        echo '<a href="../../VIEW_USERS/perfil_user.php">Volver al perfil</a>';
    }
    ?>
</body>
</html>
