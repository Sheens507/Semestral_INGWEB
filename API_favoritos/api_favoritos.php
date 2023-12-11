<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener los parámetros enviados en la URL
    $id_usuario = $_GET['id_usuario'] ?? null;
    $username = $_GET['usuario'] ?? null;
    
    // Verificar la existencia de los parámetros
    if (!$id_usuario || !$username) {
        http_response_code(400); // Solicitud incorrecta
        echo json_encode(array("message" => "Faltan parámetros"));
        exit();
    }
    
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

    // Consulta SQL para obtener los datos del usuario usando los parámetros
    $sql = "SELECT Fav_url, Fav_nombre_cancion, Fav_artista_cancion FROM favoritos WHERE Fav_ID_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $datos_favoritos = $resultado->fetch_all(MYSQLI_ASSOC);
        
        http_response_code(200); 
        echo json_encode($datos_favoritos);
    } else {
        http_response_code(404); // No encontrado
        echo json_encode(array("message" => "No se encontraron datos para el usuario"));
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405); // Método no permitido
    echo json_encode(array("message" => "Método no permitido"));
}