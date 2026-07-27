<?php
// delete_exam.php
require_once 'config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // ON DELETE CASCADE will handle exam_questions and exam_schedule deletion
    $stmt = $pdo->prepare("DELETE FROM exam_master WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: exam_list.php");
exit;
?>
