<?php
function obtenerDatosBusqueda() {
    $nombreservidor = "localhost";
    $nombreusuario = "root";
    $password = "";
    $basedatos = "prueba";

    $conn = new mysqli($nombreservidor, $nombreusuario, $password, $basedatos);

    if ($conn->connect_error) {
        return array("error" => "Error en la conexión a la base de datos");
    }

    $sql = "SELECT Bus_nombre FROM busqueda ORDER BY Bus_ID DESC LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nombre_busqueda);
        $datos_busqueda = array();
        while ($stmt->fetch()) {
            $datos_busqueda[] = array("Bus_nombre" => $nombre_busqueda);
        }
        $stmt->close();
        $conn->close();
        return $datos_busqueda;
    } else {
        $stmt->close();
        $conn->close();
        return array("message" => "No se encontraron datos de búsqueda");
    }
}

