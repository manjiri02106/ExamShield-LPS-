<?php
// backend/config/database.php

class Database {
    private $host = '127.0.0.1';
    private $db_name = 'examshield_lps';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";charset=utf8mb4", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create database if not exists
            $this->conn->exec("CREATE DATABASE IF NOT EXISTS `" . $this->db_name . "`");
            $this->conn->exec("USE `" . $this->db_name . "`");

        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
