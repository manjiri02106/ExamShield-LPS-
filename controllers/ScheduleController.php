<?php
// controllers/ScheduleController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ExamSchedule.php';

class ScheduleController {
    private $db;
    private $examSchedule;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->examSchedule = new ExamSchedule($this->db);
    }

    public function getScheduleByExam($exam_id) {
        return $this->examSchedule->readByExam($exam_id);
    }

    public function saveSchedule($data) {
        // We can use this later if we extract POST logic, but for now we just need the read
    }
}
?>
