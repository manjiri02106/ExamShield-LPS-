<?php
// backend/api/delete_exam.php
header("Content-Type: application/json");
require_once __DIR__ . '/../controllers/ExamController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $controller = new ExamController();
    $result = $controller->deleteExam($_POST['id']);
    echo json_encode($result);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
}
?>
