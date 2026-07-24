<?php

declare(strict_types=1);

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../controllers/ReminderController.php";

header("Content-Type: application/json");

try {

    $student = $conn->query("SELECT * FROM students WHERE student_id = 1")->fetch(PDO::FETCH_ASSOC);
    $exam = $conn->query("SELECT * FROM exams WHERE exam_id = 1")->fetch(PDO::FETCH_ASSOC);

    if (!$student || !$exam) {
        throw new Exception("Student or Exam data not found.");
    }

    $controller = new ReminderController();

    $response = $controller->sendReminder(
        $student["email"],
        $student["name"],
        $exam["subject"],
        $exam["exam_date"],
        $exam["exam_time"]
    );

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}

?>