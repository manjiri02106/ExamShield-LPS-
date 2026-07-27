<?php
// backend/api/get_questions.php
header("Content-Type: application/json");
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Question.php';

if (isset($_GET['subject_id'])) {
    $database = new Database();
    $db = $database->getConnection();
    
    $question = new Question($db);
    $question->subject_id = (int)$_GET['subject_id'];
    
    $stmt = $question->getQuestionsBySubject();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($questions) > 0) {
        echo json_encode(["status" => "success", "questions" => $questions]);
    } else {
        echo json_encode(["status" => "error", "message" => "No questions found for this subject."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
?>
