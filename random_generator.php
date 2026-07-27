<?php
// random_generator.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_id = (int)$_POST['subject_id'];
    $easyCount = (int)$_POST['easy'];
    $mediumCount = (int)$_POST['medium'];
    $hardCount = (int)$_POST['hard'];
    
    $selected_questions = [];
    
    // Function to fetch random questions by difficulty
    function fetchRandom($pdo, $subject, $difficulty, $limit) {
        if ($limit <= 0) return [];
        $stmt = $pdo->prepare("SELECT id, question_text, marks FROM question_bank WHERE subject_id = ? AND difficulty = ? ORDER BY RAND() LIMIT ?");
        // PDO limit parameter needs to be integer specifically bound
        $stmt->bindValue(1, $subject, PDO::PARAM_INT);
        $stmt->bindValue(2, $difficulty, PDO::PARAM_STR);
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    try {
        $easyQs = fetchRandom($pdo, $subject_id, 'Easy', $easyCount);
        $mediumQs = fetchRandom($pdo, $subject_id, 'Medium', $mediumCount);
        $hardQs = fetchRandom($pdo, $subject_id, 'Hard', $hardCount);
        
        $selected_questions = array_merge($easyQs, $mediumQs, $hardQs);
        
        if (count($selected_questions) < ($easyCount + $mediumCount + $hardCount)) {
            // Found less questions than requested
            echo json_encode(['status' => 'success', 'message' => 'Not enough questions in bank, returned available.', 'questions' => $selected_questions]);
        } else {
            echo json_encode(['status' => 'success', 'questions' => $selected_questions]);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}
?>
