<?php
// question_bank.php
require_once 'config.php';
require_once 'controllers/QuestionBankController.php';

$controller = new QuestionBankController();

if (isset($_GET['action']) && $_GET['action'] == 'get_questions' && isset($_GET['subject_id'])) {
    $subject_id = (int)$_GET['subject_id'];
    
    $database = new Database();
    $db = $database->getConnection();
    $questionBank = new QuestionBank($db);
    $stmt = $questionBank->readBySubject($subject_id);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($questions) == 0) {
        echo '<div class="alert alert-warning">No questions found for this subject.</div>';
        exit;
    }
    
    echo '<div class="list-group">';
    foreach ($questions as $q) {
        $badgeColor = 'bg-secondary';
        if ($q['difficulty'] == 'Easy') $badgeColor = 'bg-success';
        if ($q['difficulty'] == 'Medium') $badgeColor = 'bg-warning text-dark';
        if ($q['difficulty'] == 'Hard') $badgeColor = 'bg-danger';
        
        echo '<label class="list-group-item d-flex gap-3 align-items-start">';
        echo '<input class="form-check-input flex-shrink-0 q-checkbox mt-1" type="checkbox" value="'.$q['id'].'" data-marks="'.$q['marks'].'" data-text="'.htmlspecialchars($q['question_text']).'">';
        echo '<div>';
        echo '<div class="fw-bold mb-1">'.htmlspecialchars($q['question_text']).'</div>';
        echo '<span class="badge '.$badgeColor.' me-2">'.$q['difficulty'].'</span>';
        echo '<span class="badge bg-info me-2">Unit '.$q['unit'].'</span>';
        echo '<span class="badge bg-dark me-2">'.$q['type'].'</span>';
        echo '<span class="text-primary fw-bold" style="font-size: 0.85rem;"><i class="fas fa-star"></i> '.$q['marks'].' Marks</span>';
        echo '</div>';
        echo '</label>';
    }
    echo '</div>';
    exit;
}
?>
