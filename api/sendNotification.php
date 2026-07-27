<?php

require_once "../controllers/NotificationController.php";

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

?>