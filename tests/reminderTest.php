<?php

require_once "../controllers/ReminderController.php";

$controller = new ReminderController();

$response = $controller->sendReminder(
    "tahavsbizz07@gmail.com",
    "Taha",
    "Database Management System",
    "5 August 2026",
    "9:00 AM"
);

echo "<pre>";
print_r($response);
echo "</pre>";

?>