<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

// Only SUPER_ADMIN can access this page
checkRole("SUPER_ADMIN");

// Fetch departments
$sql = "SELECT id, department_name
        FROM departments
        ORDER BY department_name ASC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Create Admin</title>

</head>

<body>

    <h1>Create Admin</h1>

    <p>
        Logged in as:
        <?php echo htmlspecialchars($_SESSION['name']); ?>
    </p>

    <hr>

    <form
        action="create_admin_process.php"
        method="POST"
    >

        <label>Admin Name</label>

        <br>

        <input
            type="text"
            name="name"
            required
        >

        <br><br>

        <label>Email</label>

        <br>

        <input
            type="email"
            name="email"
            required
        >

        <br><br>

        <label>Default Password</label>

        <br>

        <input
            type="password"
            name="password"
            required
        >

        <br><br>

        <label>Department</label>

        <br>

        <select
            name="department_id"
            required
        >

            <option value="">Select Department</option>

            <?php while ($department = $result->fetch_assoc()) { ?>

                <option value="<?php echo $department['id']; ?>">

                    <?php echo htmlspecialchars($department['department_name']); ?>

                </option>

            <?php } ?>

        </select>

        <br><br>

        <button type="submit">

            Create Admin

        </button>

    </form>

    <br>

    <a href="../dashboard/super_admin.php">

        Back to Dashboard

    </a>

</body>

</html>