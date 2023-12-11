<?php
session_start();

// Datos de conexión
$nombreservidor = "localhost";
$nombreusuario = "root";
$password = "";
$basedatos = "prueba";

// Estableciendo conexion con la BD
$conn = new mysqli($nombreservidor, $nombreusuario, $password, $basedatos);

// Verificando la conexión con la BD
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Verificando si hay datos enviados por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obteniendo los datos del formulario
    $usuario_nombre = $_POST['usuario'];
    $password = $_POST['password'];
    $correo = $_POST['correo'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_cumple = $_POST['fecha'];

    // Validación
    $usuario_nombre = mysqli_real_escape_string($conn, $usuario_nombre);
    $password = mysqli_real_escape_string($conn, $password);
    $correo = mysqli_real_escape_string($conn, $correo);
    $nombre = mysqli_real_escape_string($conn, $nombre);
    $apellido = mysqli_real_escape_string($conn, $apellido);
    $fecha_cumple = mysqli_real_escape_string($conn, $fecha_cumple);

    // Verificando que el password tenga una longitud de 8 a 15 caracteres
    $longitud = strlen($password);

    // Verificación de existencia de usuario
    $sql = "SELECT COUNT(*) as total FROM usuario WHERE Usu_nombre = '$usuario_nombre' OR Usu_email = '$correo'";
    $resultado = $conn->query($sql);

    if ($resultado) {
        $row = $resultado->fetch_assoc();
        $total = $row['total'];

        if ($longitud < 8) {
            $errorLongitud = "La contraseña es muy corta";
            setcookie("datos_ultimo_ingreso", json_encode($_POST), time() + 60, "/"); 
        } elseif ($longitud > 15) {
            $errorLongitud = "La contraseña es muy larga";
            setcookie("datos_ultimo_ingreso", json_encode($_POST), time() + 60, "/"); 
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)){
            $errorCorreo = "El correo electrónico no es válido";
            setcookie("datos_ultimo_ingreso", json_encode($_POST), time() + 60, "/"); 
        } else {
            if ($total > 0) {
                $errorExistencia = "El usuario o el correo electrónico ya están en uso";
                setcookie("datos_ultimo_ingreso", json_encode($_POST), time() + 60, "/"); 
            } else {
                // Preparar la consulta SQL para insertar un nuevo usuario
                $sql = "INSERT INTO Usuario (Usu_user, Usu_password, Usu_email, Usu_nombre, Usu_apellido, Usu_fechacumple, Usu_tipo) VALUES (?, ?, ?, ?, ?, ?, 'regular')";
                $statement = $conn->prepare($sql);
            
                // Verificar si la preparación de la consulta fue exitosa
                if ($statement) {
                    // Vincular los parámetros y ejecutar la consulta
                    $statement->bind_param("ssssss", $usuario_nombre, $password, $correo, $nombre, $apellido, $fecha_cumple);
                    if ($statement->execute()) {
                        $mensajeExito = "Registro exitoso";
                        // Eliminar la cookie si el registro fue exitoso
                        setcookie("datos_ultimo_ingreso", "", time() - 3600, "/");
                    } else {
                        $mensajeError = "Error al registrar el usuario: " . $conn->error; // Manejo de errores mejorado
                    }
            
                    // Cerrar la declaración
                    $statement->close();
                } else {
                    $mensajeError = "Error en la preparación de la consulta: " . $conn->error;
                }
            }            
            
        }
    }
    } else {
        echo "Error en la consulta" . $conn->error;
    }

$conn->close();
?>


<!DOCTYPE html>
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
        echo '<a href="index.php">Ir a Iniciar Sesión</a>';
    }
    // Si es un mensaje de error
    elseif (!empty($errorLongitud) || !empty($errorCorreo) || !empty($errorExistencia) || !empty($mensajeError)) {
        if (!empty($errorLongitud)) {
            echo "<p>$errorLongitud</p>";
        }
        if (!empty($errorCorreo)) {
            echo "<p>$errorCorreo</p>";
        }
        if (!empty($errorExistencia)) {
            echo "<p>$errorExistencia</p>";
        }
        if (!empty($mensajeError)) {
            echo "<p>$mensajeError</p>";
        }
        echo '<a href="Registro.php">Volver al Formulario</a>';
    }
    ?>
</body>
</html>