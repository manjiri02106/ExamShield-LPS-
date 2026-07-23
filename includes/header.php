<?php
/**
 * ==========================================
 * ExamShield LPS
 * Header File
 * ==========================================
 */

require_once(__DIR__ . '/../config/config.php');

$pageTitle = isset($pageTitle) ? $pageTitle : APP_NAME;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $pageTitle; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Project CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/dashboard.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/report.css">

</head>

<body>

<div class="wrapper">

    <!-- Sidebar -->
    <?php
    if (file_exists(__DIR__ . '/sidebar.php')) {
        include(__DIR__ . '/sidebar.php');
    }
    ?>

    <!-- Main Content -->
    <div class="main-content">

        <!-- Navbar -->
        <?php
        if (file_exists(__DIR__ . '/navbar.php')) {
            include(__DIR__ . '/navbar.php');
        }
        ?>