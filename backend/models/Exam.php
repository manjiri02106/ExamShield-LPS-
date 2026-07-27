<?php
// backend/models/Exam.php

class Exam {
    private $conn;
    private $table_name = "exam_master";

    public $id;
    public $title;
    public $subject_id;
    public $department_id;
    public $semester;
    public $year;
    public $exam_type;
    public $total_marks;
    public $passing_marks;
    public $instructions;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (title, subject_id, department_id, semester, year, exam_type, total_marks, passing_marks, instructions, status) 
                  VALUES (:title, :subject_id, :department_id, :semester, :year, :exam_type, :total_marks, :passing_marks, :instructions, :status)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":subject_id", $this->subject_id);
        $stmt->bindParam(":department_id", $this->department_id);
        $stmt->bindParam(":semester", $this->semester);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":exam_type", $this->exam_type);
        $stmt->bindParam(":total_marks", $this->total_marks);
        $stmt->bindParam(":passing_marks", $this->passing_marks);
        $stmt->bindParam(":instructions", $this->instructions);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function publish($status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getExam() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
