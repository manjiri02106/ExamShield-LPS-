<?php
// config/database.php

class Database {
    private $host = 'localhost';
    private $db_name = 'examshield_lps';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";charset=utf8mb4", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Ensure database exists and select it
            $this->conn->exec("CREATE DATABASE IF NOT EXISTS `" . $this->db_name . "`");
            $this->conn->exec("USE `" . $this->db_name . "`");

        } catch(PDOException $exception) {
            die("Database Connection Error: " . $exception->getMessage());
        }

        return $this->conn;
    }
}
?>
