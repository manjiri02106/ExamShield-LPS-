<?php
// models/ExamMaster.php

class ExamMaster {
    private $conn;
    private $table_name = "exam_master";

    public $id;
    public $title;
    public $department_id;
    public $subject_id;
    public $semester;
    public $year;
    public $exam_type;
    public $total_marks;
    public $passing_marks;
    public $duration_minutes;
    public $status;
    public $created_by;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT e.*, d.name as department_name, s.name as subject_name FROM " . $this->table_name . " e LEFT JOIN departments d ON e.department_id = d.id LEFT JOIN subjects s ON e.subject_id = s.id ORDER BY e.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT e.*, d.name as department_name, s.name as subject_name FROM " . $this->table_name . " e LEFT JOIN departments d ON e.department_id = d.id LEFT JOIN subjects s ON e.subject_id = s.id WHERE e.id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET title=:title, department_id=:department_id, subject_id=:subject_id, semester=:semester, year=:year, exam_type=:exam_type, total_marks=:total_marks, passing_marks=:passing_marks, duration_minutes=:duration_minutes, status=:status, created_by=:created_by";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":department_id", $this->department_id);
        $stmt->bindParam(":subject_id", $this->subject_id);
        $stmt->bindParam(":semester", $this->semester);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":exam_type", $this->exam_type);
        $stmt->bindParam(":total_marks", $this->total_marks);
        $stmt->bindParam(":passing_marks", $this->passing_marks);
        $stmt->bindParam(":duration_minutes", $this->duration_minutes);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created_by", $this->created_by);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function updateStatus() {
        $query = "UPDATE " . $this->table_name . " SET status=:status WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }

    public function getStats() {
        $stats = [
            'total' => 0,
            'published' => 0,
            'scheduled' => 0,
            'draft' => 0
        ];
        
        $query = "SELECT status, COUNT(*) as count FROM " . $this->table_name . " GROUP BY status";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $total = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $status = strtolower($row['status']);
            if(isset($stats[$status])) {
                $stats[$status] = $row['count'];
            }
            $total += $row['count'];
        }
        $stats['total'] = $total;
        
        // Ensure keys exist even if no data
        return $stats;
    }
}
?>
