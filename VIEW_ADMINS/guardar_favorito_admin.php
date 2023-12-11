<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Si no hay usuario autenticado, redirigirlo a la página de inicio de sesión
    header("Location: index.php");
    exit(); // Asegurarse de que el script se detenga después de redirigir
}
$username = $_SESSION['usuario'];
$id_usuario = $_SESSION['id_usuario'];
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "prueba";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre_cancion = $_POST['nombre_cancion'];
    $nombre_artista = $_POST['nombre_artista'];

    // Preparar la consulta para insertar en la base de datos
    $sql = "INSERT INTO favoritos (Fav_ID_cancion, Fav_nombre_cancion, Fav_artista_cancion, Fav_ID_usuario) VALUES ('$id', '$nombre_cancion', '$nombre_artista', '$id_usuario')";

    if ($conn->query($sql) === TRUE) {
        $mensajeExito = "Canción añadida a favoritos correctamente";

        //Cookie que almacena ultima canción agregada a favoritos
    $cookie_name = "favorito_" . $id_usuario; 
    $cookie_value = json_encode(array('nombre_cancion' => $nombre_cancion, 'nombre_artista' => $nombre_artista));
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
    
    } else {
        $mensajeError = "Error al añadir canción a favoritos: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar en favoritos</title>
    <link href="../styles/style.css" rel="stylesheet">
</head>
<body>
<?php
    // Si es un mensaje de registro exitoso
    if (!empty($mensajeExito)) {
        echo "<p>$mensajeExito</p>";
        echo '<a href="../VIEW_ADMINS/index_admin.php">Ir a Home</a>';
    } else {
        echo "<p>$mensajeError</p>";
        echo '<a href="../VIEW_ADMINS/index_admin.php">Ir a Home</a>';
    }
    
    ?>
</body>
</html>