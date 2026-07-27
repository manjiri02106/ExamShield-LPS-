<?php
// controllers/QuestionBankController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/QuestionBank.php';
require_once __DIR__ . '/../models/Subject.php';

class QuestionBankController {
    private $db;
    private $questionBank;
    private $subject;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->questionBank = new QuestionBank($this->db);
        $this->subject = new Subject($this->db);
    }

    public function getAllQuestions() {
        $stmt = $this->questionBank->readAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSubjects() {
        $stmt = $this->subject->readAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
