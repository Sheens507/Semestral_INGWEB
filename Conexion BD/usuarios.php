<?php
// aqui lo que hace es las funciones en SQL para obtener los datos de la tabla
include_once 'bd.php';

class procesos extends DB {

    function obtenerUsuarios(){
        // Poner nombre de la tabla
        $query = $this->connect()->query('SELECT * FROM users');

        return $query;
    }

    function obtenerFav(){
        // Poner nombre de la tabla
        $query = $this->connect()->query('SELECT * FROM fav');

        return $query;
    }
}

?>