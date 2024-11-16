<?php
class Connection
{
    private static $instance;
    private function __construct()
    {
        $hostname = "localhost";
        $database = "lunodoro";
        $username = "root";
        $password = "As45Wd678Ty@";
        $dsn = "mysql:host=$hostname;dbname=$database";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        try {
            self::$instance = new PDO($dsn, $username, $password, $options);
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
    }

    public static function getConnection(): PDO
    {
        if (!isset(self::$instance)) {
            new Connection();
        }
        return self::$instance;
    }
}
