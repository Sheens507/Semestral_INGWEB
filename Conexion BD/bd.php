<?php
// Puedes usar gaby este documento pra hacer la conexion a la base de datos
class DB{
    private $host;
    private $DB;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host = 'localhost';
        $this->DB = 'semestral';
        $this->user = 'root';
        $this->password = '';
        $this->charset = 'utf8mb4';
    }
    
    function connect(){
        try {
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->DB . ";charset=utf8mb4";

            $option = [
                PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES  => false,
            ];
            $pdo = new PDO($connection, $this->user, $this->password);
            
            return $pdo;
        } catch (PDOException $e) {
            print_r('Error connection: ' . $e->getMessage());
        }
    }
}
