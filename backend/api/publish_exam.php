<?php
// backend/api/publish_exam.php
header("Content-Type: application/json");
require_once __DIR__ . '/../controllers/ExamController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
    $controller = new ExamController();
    $result = $controller->publishExam($_POST['id'], $_POST['status']);
    echo json_encode($result);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
}
?>
