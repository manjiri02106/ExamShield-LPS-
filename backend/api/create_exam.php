<?php
// backend/api/create_exam.php
header("Content-Type: application/json");
require_once __DIR__ . '/../controllers/ExamController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new ExamController();
    $result = $controller->createExam($_POST);
    echo json_encode($result);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
}
?>
