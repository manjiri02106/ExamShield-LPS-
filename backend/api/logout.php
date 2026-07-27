<?php
// backend/api/logout.php
header("Content-Type: application/json");
require_once __DIR__ . '/../controllers/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controller = new AuthController();
    $result = $controller->logout();
    // Return JSON if AJAX, otherwise redirect could be handled by frontend
    echo json_encode($result);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
?>
