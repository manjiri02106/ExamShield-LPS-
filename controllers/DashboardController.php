<?php
// controllers/DashboardController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ExamMaster.php';

class DashboardController {
    private $db;
    private $examMaster;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->examMaster = new ExamMaster($this->db);
    }

    public function getStats() {
        return $this->examMaster->getStats();
    }
}
?>
