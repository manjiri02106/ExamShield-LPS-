<?php
// backend/models/Question.php

class Question {
    private $conn;
    private $table_name = "question_bank";

    public $id;
    public $subject_id;
    public $difficulty;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getQuestionsBySubject() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE subject_id = :subject_id ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":subject_id", $this->subject_id);
        $stmt->execute();
        
        return $stmt;
    }

    public function getRandomQuestions($easy_count, $medium_count, $hard_count) {
        $questions = [];

        // Fetch Easy
        if($easy_count > 0) {
            $q = $this->fetchRandomByDifficulty('Easy', $easy_count);
            $questions = array_merge($questions, $q);
        }
        // Fetch Medium
        if($medium_count > 0) {
            $q = $this->fetchRandomByDifficulty('Medium', $medium_count);
            $questions = array_merge($questions, $q);
        }
        // Fetch Hard
        if($hard_count > 0) {
            $q = $this->fetchRandomByDifficulty('Hard', $hard_count);
            $questions = array_merge($questions, $q);
        }

        return $questions;
    }

    private function fetchRandomByDifficulty($difficulty, $limit) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE subject_id = :subject_id AND difficulty = :difficulty 
                  ORDER BY RAND() LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':subject_id', $this->subject_id, PDO::PARAM_INT);
        $stmt->bindParam(':difficulty', $difficulty, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
