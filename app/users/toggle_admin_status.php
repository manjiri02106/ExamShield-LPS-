<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

// Only SUPER_ADMIN can access
checkRole("SUPER_ADMIN");

// Check ID
if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$admin_id = intval($_GET['id']);

// Prevent Super Admin from changing their own status
if ($admin_id == $_SESSION['user_id']) {
    die("You cannot change your own account status.");
}

// Get admin information
$sql = "SELECT id, role, status
        FROM users
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Admin not found.");
}

$user = $result->fetch_assoc();

// Ensure only ADMIN accounts can be modified
if ($user['role'] != "ADMIN") {
    die("Only Admin accounts can be modified.");
}

// Toggle status
$newStatus = ($user['status'] == "ACTIVE") ? "INACTIVE" : "ACTIVE";

$updateSql = "UPDATE users
              SET status = ?
              WHERE id = ?";

$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("si", $newStatus, $admin_id);

if ($updateStmt->execute()) {

    header("Location: view_admins.php");
    exit();

} else {

    die("Failed to update status.");

}

?>