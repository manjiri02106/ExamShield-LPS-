<?php
// backend/api/schedule_exam.php
header("Content-Type: application/json");
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Schedule.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['exam_id'])) {
    $database = new Database();
    $db = $database->getConnection();
    
    $schedule = new Schedule($db);
    $schedule->exam_id = $_POST['exam_id'];
    $schedule->exam_date = $_POST['exam_date'];
    $schedule->start_time = $_POST['start_time'];
    $schedule->end_time = $_POST['end_time'];
    $schedule->duration = $_POST['duration'];
    
    if($schedule->create()) {
        // Optionally update exam status to Scheduled
        require_once __DIR__ . '/../models/Exam.php';
        $exam = new Exam($db);
        $exam->id = $schedule->exam_id;
        $exam->publish('Scheduled');
        
        echo json_encode(["status" => "success", "message" => "Exam Scheduled Successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to schedule exam."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
?>
