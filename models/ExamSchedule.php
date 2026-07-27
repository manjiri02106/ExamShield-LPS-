<?php
// models/ExamSchedule.php

class ExamSchedule {
    private $conn;
    private $table_name = "exam_schedule";

    public $id;
    public $exam_id;
    public $exam_date;
    public $start_time;
    public $end_time;
    public $room_no;
    public $invigilator_name;
    public $instructions;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readByExam($exam_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE exam_id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $exam_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET exam_id=:exam_id, exam_date=:exam_date, start_time=:start_time, end_time=:end_time, room_no=:room_no, invigilator_name=:invigilator_name, instructions=:instructions";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":exam_id", $this->exam_id);
        $stmt->bindParam(":exam_date", $this->exam_date);
        $stmt->bindParam(":start_time", $this->start_time);
        $stmt->bindParam(":end_time", $this->end_time);
        $stmt->bindParam(":room_no", $this->room_no);
        $stmt->bindParam(":invigilator_name", $this->invigilator_name);
        $stmt->bindParam(":instructions", $this->instructions);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET exam_date=:exam_date, start_time=:start_time, end_time=:end_time, room_no=:room_no, invigilator_name=:invigilator_name, instructions=:instructions WHERE exam_id=:exam_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":exam_id", $this->exam_id);
        $stmt->bindParam(":exam_date", $this->exam_date);
        $stmt->bindParam(":start_time", $this->start_time);
        $stmt->bindParam(":end_time", $this->end_time);
        $stmt->bindParam(":room_no", $this->room_no);
        $stmt->bindParam(":invigilator_name", $this->invigilator_name);
        $stmt->bindParam(":instructions", $this->instructions);

        return $stmt->execute();
    }
}
?>
