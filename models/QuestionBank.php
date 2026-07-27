<?php
// models/QuestionBank.php

class QuestionBank {
    private $conn;
    private $table_name = "question_bank";

    public $id;
    public $subject_id;
    public $question_text;
    public $question_type; // Maps to `type` in DB
    public $marks;
    public $difficulty_level; // Maps to `difficulty` in DB
    public $unit;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT q.*, s.name as subject_name FROM " . $this->table_name . " q LEFT JOIN subjects s ON q.subject_id = s.id ORDER BY q.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readBySubject($subject_id, $limit = null) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE subject_id = ? ORDER BY RAND()";
        if($limit) {
            $query .= " LIMIT " . (int)$limit;
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $subject_id);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET subject_id=:subject_id, unit=:unit, question_text=:question_text, type=:type, marks=:marks, difficulty=:difficulty";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":subject_id", $this->subject_id);
        $stmt->bindParam(":unit", $this->unit);
        $stmt->bindParam(":question_text", $this->question_text);
        $stmt->bindParam(":type", $this->question_type);
        $stmt->bindParam(":marks", $this->marks);
        $stmt->bindParam(":difficulty", $this->difficulty_level);

        return $stmt->execute();
    }
}
?>
