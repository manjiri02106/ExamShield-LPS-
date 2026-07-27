<?php
session_start();

if (!isset($_SESSION['id'])) {
   header("Location: dashboard.php");
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h2>Welcome <?php echo $_SESSION['name']; ?></h2>

<h3>Role: <?php echo $_SESSION['role']; ?></h3>

<a href="logout.php">Logout</a>

</body>
</html>
