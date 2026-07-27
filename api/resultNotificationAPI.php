<?php

require_once "../controllers/ResultController.php";

$controller = new ResultController();

$response = $controller->sendResult(
    "tahavsbizz07@gmail.com",
    "Taha",
    "Data Structures",
    "PASS",
    "89/100"
);

header("Content-Type: application/json");

echo json_encode($response, JSON_PRETTY_PRINT);

?>