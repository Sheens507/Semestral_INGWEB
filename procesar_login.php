<?php
session_start();

// Datos de conexión
$nombreservidor = "localhost";
$nombreusuario = "root";
$password = "";
$basedatos = "prueba";

// Estableciendo conexion con la BD
$conn = new mysqli($nombreservidor, $nombreusuario, $password, $basedatos);

// Verificando la conexion con la BD
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Obteniendo los datos de formulario
$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Consulta SQL para verifical el usuario
$sql = "SELECT*FROM Usuario WHERE Usu_user='$usuario' AND Usu_password='$password'";
$resultado = $conn->query($sql);

if ($resultado->num_rows == 1) {
    //Usuario autenticado correctamente
    $row = $resultado->fetch_assoc();
    $_SESSION['usuario'] = $usuario;
    $_SESSION['tipo_usuario'] = $row['Usu_tipo'];
    $_SESSION['id_usuario'] = $row['Usu_ID'];

    if ($_SESSION['tipo_usuario'] == 'admin') {
        header("Location: VIEW_ADMINS/index_admin.php"); // Redirecciona a la página para admin
    } else {
        header("Location: VIEW_USERS/index_users.php"); // Redirecciona a la página de usuario regular
    }
}else {
    // Usuario no encontrado 
    echo "Nombre de usuario o contraseña incorrectos";
    echo '<a href="Login.php">Volver al Formulario</a>';
}
