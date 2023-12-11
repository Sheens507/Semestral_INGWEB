<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $nombreservidor = "localhost";
    $nombreusuario = "root";
    $password = "";
    $basedatos = "prueba";

    // Establecer conexión con la BD
    $conn = new mysqli($nombreservidor, $nombreusuario, $password, $basedatos);

    // Verificar la conexión con la BD
    if ($conn->connect_error) {
        http_response_code(500); 
        echo json_encode(array("message" => "Error en la conexión a la base de datos"));
        exit();
    }

    // Consulta SQL para obtener todos los usuarios
    $sql = "SELECT Fav_nombre_cancion, Fav_artista_cancion, Usu_user FROM favoritos JOIN usuario ON Fav_ID_usuario = Usu_ID";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $datos_favoritos = $resultado->fetch_all(MYSQLI_ASSOC);
        http_response_code(200); 
        echo json_encode($datos_favoritos);
    } else {
        http_response_code(404); // No encontrado
        echo json_encode(array("message" => "No se encontraron datos de favoritos"));
    }

    $conn->close();
} else {
    http_response_code(405); // Método no permitido
    echo json_encode(array("message" => "Método no permitido"));
}

