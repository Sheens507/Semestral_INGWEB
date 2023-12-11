<?php

include_once '../Conexion BD/usuarios.php';

class ApiUsuarios {
    function getAllUsuarios() {
        $procesos = new procesos(); // Supongamos que tienes una clase Usuario que maneja la información de los usuarios.
        $usuarios = array();
        $usuarios["items"] = array();
    
        $res = $procesos->obtenerUsuarios(); // Supongamos que esta función obtiene la información de todos los usuarios.
    
        if ($res->rowCount()) {
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $item = array(
                    'id' => $row['id'],
                    'nombre' => $row['nombre'],
                    'password' => $row['password']
                    // Puedes agregar más campos según las propiedades de tus usuarios
                );
                array_push($usuarios['items'], $item);
            }
    
            echo json_encode($usuarios);
        } else {
            echo json_encode(array('mensaje' => 'No hay usuarios registrados'));
        }
    }

    function getAllFav() {
        $procesos = new procesos(); // Supongamos que tienes una clase Usuario que maneja la información de los usuarios.
        $favoritos = array();
        $favoritos["items"] = array();
    
        $res = $procesos->obtenerFav(); // Supongamos que esta función obtiene la información de todos los usuarios.
    
        if ($res->rowCount()) {
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $item = array(
                    'id' => $row['id'],
                    'song' => $row['song'],
                    'user' => $row['user']
                    // Puedes agregar más campos según las propiedades de tus tabla fav
                );
                array_push($favoritos['items'], $item);
            }
    
            echo json_encode($favoritos);
        } else {
            echo json_encode(array('mensaje' => 'No hay favoritos guardados'));
        }
    }
}

?>
