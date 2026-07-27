<?php
// backend/api/get_exam.php
header("Content-Type: application/json");
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Exam.php';

if (isset($_GET['id'])) {
    $database = new Database();
    $db = $database->getConnection();
    
    $exam = new Exam($db);
    $exam->id = (int)$_GET['id'];
    
    $data = $exam->getExam();
    
    if ($data) {
        echo json_encode(["status" => "success", "exam" => $data]);
    } else {
        echo json_encode(["status" => "error", "message" => "Exam not found."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
?>
