<?php
// backend/api/random_questions.php
header("Content-Type: application/json");
require_once __DIR__ . '/../controllers/QuestionController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subject_id'])) {
    $subject_id = $_POST['subject_id'];
    $easy = $_POST['easy'] ?? 0;
    $medium = $_POST['medium'] ?? 0;
    $hard = $_POST['hard'] ?? 0;

    $controller = new QuestionController();
    $result = $controller->getRandomQuestions($subject_id, $easy, $medium, $hard);
    echo json_encode($result);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
}
?>
