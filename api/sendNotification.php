<?php

require_once "../controllers/NotificationController.php";

$controller = new NotificationController();

$response = $controller->send(
    "tahavsbizz07@gmail.com",
    "Test Notification",
    "<h2>ExamShield LPS</h2>
     <p>This is a test notification sent through the Notification Module.</p>"
);

header("Content-Type: application/json");

echo json_encode($response, JSON_PRETTY_PRINT);

?>