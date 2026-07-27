<?php
// backend/api/login.php
header("Content-Type: application/json");
require_once __DIR__ . '/../controllers/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $controller = new AuthController();
    $result = $controller->login($_POST['username'], $_POST['password']);
    echo json_encode($result);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
?>
