<?php

require_once "../controllers/ResultController.php";

header("Content-Type: application/json");

$controller = new ResultController();

$response = $controller->sendResult(
    "tahavsbizz07@gmail.com",
    "Taha",
    "Data Structures",
    "PASS",
    "89/100"
);

echo json_encode($response, JSON_PRETTY_PRINT);

?>