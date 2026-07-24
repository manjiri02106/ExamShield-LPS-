<?php

declare(strict_types=1);

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../controllers/NotificationController.php";

header("Content-Type: application/json");

try {

    $query = $conn->prepare("SELECT name, email FROM students WHERE student_id = ?");
    $studentId = 1;

    $query->bind_param("i", $studentId);
    $query->execute();

    $result = $query->get_result();
    $student = $result->fetch_assoc();

    if (!$student) {
        throw new Exception("Student not found.");
    }

    $controller = new NotificationController();

    $response = $controller->send(
        $student["email"],
        "Welcome to ExamShield LPS",
        "
        <h2>ExamShield LPS</h2>
        <p>Hello <b>{$student['name']}</b>,</p>
        <p>Welcome to the ExamShield Notification System.</p>
        <p>Thank you for using our platform.</p>
        "
    );

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
?>