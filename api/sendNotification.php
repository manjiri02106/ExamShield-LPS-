<?php

require_once "../controllers/NotificationController.php";

header("Content-Type: application/json");

$controller = new NotificationController();

$response = $controller->send(
    "tahavsbizz07@gmail.com",
    "Welcome to ExamShield LPS",
    "
    <h2>ExamShield LPS</h2>
    <p>Hello <b>Taha</b>,</p>
    <p>Welcome to the ExamShield Notification System.</p>
    <p>Thank you for using our platform.</p>
    "
);

echo json_encode($response, JSON_PRETTY_PRINT);

?>