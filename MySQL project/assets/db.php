<?php

class DB
{
    private static $instance = null;
    private $conn;
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $db = 'mysql_task';

    private function __construct()
    {
        $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
    }

    public static function getinstance()
    {
        if (!self::$instance) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function getconnection()
    {
        return $this->conn;
    }
}

$inst = DB::getinstance();
$conn = $inst->getconnection();