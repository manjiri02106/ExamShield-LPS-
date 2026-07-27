<?php

require_once "../controllers/ReminderController.php";

$controller = new ReminderController();

$response = $controller->sendReminder(
    "tahavsbizz07@gmail.com",
    "Taha",
    "Data Structures",
    "30 July 2026",
    "10:00 AM"
);

header("Content-Type: application/json");

echo json_encode($response, JSON_PRETTY_PRINT);

?>