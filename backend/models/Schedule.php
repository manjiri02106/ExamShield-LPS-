<?php
// backend/models/Schedule.php

class Schedule {
    private $conn;
    private $table_name = "exam_schedule";

    public $id;
    public $exam_id;
    public $exam_date;
    public $start_time;
    public $end_time;
    public $duration;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (exam_id, exam_date, start_time, end_time, duration) 
                  VALUES (:exam_id, :exam_date, :start_time, :end_time, :duration)";
                  
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":exam_id", $this->exam_id);
        $stmt->bindParam(":exam_date", $this->exam_date);
        $stmt->bindParam(":start_time", $this->start_time);
        $stmt->bindParam(":end_time", $this->end_time);
        $stmt->bindParam(":duration", $this->duration);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
