<?php
// models/ExamQuestion.php

class ExamQuestion {
    private $conn;
    private $table_name = "exam_questions";

    public $id;
    public $exam_id;
    public $question_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readByExam($exam_id) {
        $query = "SELECT eq.*, q.question_text, q.question_type, q.marks, q.difficulty_level 
                  FROM " . $this->table_name . " eq 
                  JOIN question_bank q ON eq.question_id = q.id 
                  WHERE eq.exam_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $exam_id);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET exam_id=:exam_id, question_id=:question_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":exam_id", $this->exam_id);
        $stmt->bindParam(":question_id", $this->question_id);

        return $stmt->execute();
    }
    
    public function deleteByExam($exam_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE exam_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $exam_id);
        return $stmt->execute();
    }
}
?>
