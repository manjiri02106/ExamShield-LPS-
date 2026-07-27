<?php
// backend/controllers/AuthController.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->user = new User($db);
    }

    public function login($username, $password) {
        $this->user->username = $username;
        $this->user->password = $password;

        if($this->user->login()) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['admin_id'] = $this->user->id;
            $_SESSION['admin_name'] = $this->user->name;
            $_SESSION['role'] = $this->user->role;
            return ["status" => "success", "message" => "Login successful"];
        }
        
        return ["status" => "error", "message" => "Invalid credentials"];
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        return ["status" => "success", "message" => "Logout successful"];
    }
}
?>
