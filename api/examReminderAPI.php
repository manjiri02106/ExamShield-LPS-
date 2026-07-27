<?php

require_once "../controllers/ReminderController.php";

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