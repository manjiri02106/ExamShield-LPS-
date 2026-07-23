<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

// Only SUPER_ADMIN can access
checkRole("SUPER_ADMIN");

// Check if Admin ID is provided
if (!isset($_GET['id'])) {
    die("Invalid Request.");
}

$admin_id = intval($_GET['id']);

// Fetch Admin details
$sql = "SELECT *
        FROM users
        WHERE id = ?
        AND role = 'ADMIN'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Admin not found.");
}

$admin = $result->fetch_assoc();

// Fetch all departments
$deptSql = "SELECT id, department_name
            FROM departments
            ORDER BY department_name ASC";

$deptResult = $conn->query($deptSql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Edit Admin</title>

</head>

<body>

    <h1>Edit Admin</h1>

    <hr>

    <form
        action="edit_admin_process.php"
        method="POST"
    >

        <input
            type="hidden"
            name="id"
            value="<?php echo $admin['id']; ?>"
        >

        <label>Admin Name</label>

        <br>

        <input
            type="text"
            name="name"
            value="<?php echo htmlspecialchars($admin['name']); ?>"
            required
        >

        <br><br>

        <label>Email</label>

        <br>

        <input
            type="email"
            name="email"
            value="<?php echo htmlspecialchars($admin['email']); ?>"
            required
        >

        <br><br>

        <label>Department</label>

        <br>

        <select
            name="department_id"
            required
        >

            <?php

            while ($department = $deptResult->fetch_assoc()) {

            ?>

                <option
                    value="<?php echo $department['id']; ?>"
                    <?php
                    if ($department['id'] == $admin['department_id']) {
                        echo "selected";
                    }
                    ?>
                >

                    <?php echo htmlspecialchars($department['department_name']); ?>

                </option>

            <?php

            }

            ?>

        </select>

        <br><br>

        <button type="submit">

            Update Admin

        </button>

    </form>

    <br>

    <a href="view_admins.php">

        Back to View Admins

    </a>

</body>

</html>