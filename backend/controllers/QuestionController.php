<?php
// backend/controllers/QuestionController.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Question.php';

class QuestionController {
    private $db;
    private $question;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->question = new Question($db);
    }

    public function getRandomQuestions($subject_id, $easy, $medium, $hard) {
        $this->question->subject_id = $subject_id;
        
        try {
            $questions = $this->question->getRandomQuestions($easy, $medium, $hard);
            if(count($questions) > 0) {
                return ["status" => "success", "questions" => $questions];
            } else {
                return ["status" => "error", "message" => "No questions found for the given criteria."];
            }
        } catch(Exception $e) {
            return ["status" => "error", "message" => "Database error: " . $e->getMessage()];
        }
    }
}
?>
