<?php
// publish_exam.php
require_once 'config.php';

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'toggle') {
    $id = (int)$_GET['id'];
    
    $stmt = $pdo->prepare("SELECT status FROM exam_master WHERE id = ?");
    $stmt->execute([$id]);
    $exam = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($exam) {
        $new_status = ($exam['status'] == 'Published') ? 'Draft' : 'Published';
        $update = $pdo->prepare("UPDATE exam_master SET status = ? WHERE id = ?");
        $update->execute([$new_status, $id]);
    }
}

header("Location: exam_list.php");
exit;
?>
