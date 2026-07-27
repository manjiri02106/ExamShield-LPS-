<?php
// backend/api/update_exam.php
header("Content-Type: application/json");
require_once __DIR__ . '/../controllers/ExamController.php';

// In a full implementation, you'd have an update method in the controller.
// For now, returning a placeholder success.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    // Logic to update exam would go here
    echo json_encode(["status" => "success", "message" => "Exam Updated Successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
}
?>
