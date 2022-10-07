<?php
class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $db = 'mysql_task';

    private static $instance = null;
    private function __construct()
    {
        $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
    }

    public static function getinstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getconnection()
    {
        return $this->conn;
    }
}