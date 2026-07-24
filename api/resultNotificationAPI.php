<?php

declare(strict_types=1);

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../controllers/ResultController.php";

header("Content-Type: application/json");

try {

    $student = $conn->query("SELECT * FROM students WHERE student_id = 1")->fetch(PDO::FETCH_ASSOC);
    $result = $conn->query("SELECT * FROM results WHERE student_id = 1")->fetch(PDO::FETCH_ASSOC);

    if (!$student || !$result) {
        throw new Exception("Student or Result data not found.");
    }

    $controller = new ResultController();

    $response = $controller->sendResult(
        $student["email"],
        $student["name"],
        $result["subject"],
        $result["grade"],
        $result["marks"]
    );

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}

?>