<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

// Only SUPER_ADMIN can access
checkRole("SUPER_ADMIN");

// Fetch all Admin users with department names
$sql = "SELECT
            users.id,
            users.name,
            users.email,
            departments.department_name,
            users.status
        FROM users
        LEFT JOIN departments
            ON users.department_id = departments.id
        WHERE users.role = 'ADMIN'
        ORDER BY users.id ASC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>View Admins</title>

</head>

<body>

    <h1>View Admins</h1>

    <hr>

    <table border="1" cellpadding="10" cellspacing="0">

        <tr>

            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Status</th>
            <th>Action</th>

        </tr>

        <?php

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

        ?>

                <tr>

                    <td><?php echo $row['id']; ?></td>

                    <td><?php echo htmlspecialchars($row['name']); ?></td>

                    <td><?php echo htmlspecialchars($row['email']); ?></td>

                    <td><?php echo htmlspecialchars($row['department_name']); ?></td>

                    <td><?php echo htmlspecialchars($row['status']); ?></td>

                    <td>

                        <?php

                        if ($row['id'] == $_SESSION['user_id']) {

                            echo "Current User";

                        } else {

                        ?>

                            <a href="edit_admin.php?id=<?php echo $row['id']; ?>">
                                Edit
                            </a>

                            &nbsp;|&nbsp;

                            <?php

                            if ($row['status'] == "ACTIVE") {

                            ?>

                                <a href="toggle_admin_status.php?id=<?php echo $row['id']; ?>">
                                    Deactivate
                                </a>

                            <?php

                            } else {

                            ?>

                                <a href="toggle_admin_status.php?id=<?php echo $row['id']; ?>">
                                    Activate
                                </a>

                            <?php

                            }

                        }

                        ?>

                    </td>

                </tr>

        <?php

            }

        } else {

        ?>

            <tr>

                <td colspan="6">
                    No Admins Found
                </td>

            </tr>

        <?php

        }

        ?>

    </table>

    <br>

    <a href="../dashboard/super_admin.php">
        Back to Dashboard
    </a>

</body>

</html>