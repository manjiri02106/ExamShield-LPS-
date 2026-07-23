<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

// Only ADMIN can create Faculty accounts
checkRole("ADMIN");

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: create_faculty.php");
    exit();
}

// Get form data
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$department_id = intval($_POST['department_id']);

// Check for empty fields
if (
    empty($name) ||
    empty($email) ||
    empty($password) ||
    empty($department_id)
) {
    die("Please fill all fields.");
}

// Check whether email already exists
$checkSql = "SELECT id FROM users WHERE email = ?";

$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $email);
$checkStmt->execute();

$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    die("A user with this email already exists.");
}

$checkStmt->close();

// Role and status are controlled by the system
$role = "FACULTY";
$status = "ACTIVE";

// Insert new Faculty
$sql = "INSERT INTO users
(
    name,
    email,
    password,
    role,
    department_id,
    status
)
VALUES
(
    ?, ?, ?, ?, ?, ?
)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssis",
    $name,
    $email,
    $password,
    $role,
    $department_id,
    $status
);

if ($stmt->execute()) {

    echo "<h2>Faculty Created Successfully!</h2>";

    echo "<p>Name: " . htmlspecialchars($name) . "</p>";
    echo "<p>Email: " . htmlspecialchars($email) . "</p>";

    echo '<a href="create_faculty.php">Create Another Faculty</a>';

    echo "<br><br>";

    echo '<a href="../dashboard/admin.php">Back to Dashboard</a>';

} else {

    echo "Failed to create Faculty.";

}

$stmt->close();
$conn->close();

?>