<?php
class Connection {
    private static $instance;
    private function __construct(){
        $host = 'localhost';
        $database = 'lunodoro';
        $username = 'root';
        $password = 'As45Wd678Ty@';
        $dsn = "mysql:host=$host;dbname=$database";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        try{
            $pdo = new PDO($dsn, $username,$password, $options);
        }catch(Exception $exception){
            echo $exception->getMessage();
            exit;
        }
    }

    public static function getConnection(){
        if(!isset(self::$instance)){
            new Connection();
        }
        return self::$instance;
    }
}
