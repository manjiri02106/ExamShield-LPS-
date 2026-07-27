
<!DOCTYPE html>
<html>
<head>
    <title>ExamShield Login</title>

<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

require_once("config/database.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Temporary Login (Replace with Database Login Later)

    if ($username == "admin" && $password == "admin123") {

        $_SESSION['user'] = "Administrator";
        $_SESSION['role'] = "Admin";

        header("Location: dashboard.php");
        exit();

    } elseif ($username == "faculty" && $password == "faculty123") {

        $_SESSION['user'] = "Faculty";
        $_SESSION['role'] = "Faculty";

        header("Location: dashboard.php");
        exit();

    } elseif ($username == "student" && $password == "student123") {

        $_SESSION['user'] = "Student";
        $_SESSION['role'] = "Student";

        header("Location: dashboard.php");
        exit();

    } else {

        $error = "Invalid Username or Password.";

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet"
          href="assets/css/login.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

>>>>>>> a38279a7f5760b8a185afbfc10268eab24731b40
</head>

<body>

<<<<<<< HEAD
<h2>Faculty Login</h2>

<form action="index.php" method="POST">

   <div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h3>
                    <i class="fas fa-user-lock"></i>
                    Login
                </h3>
            </div>

            <div class="card-body">

                <?php if($error!=""){ ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>

                <form method="POST">

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>
</form>

</body>
=======
<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header bg-primary text-white text-center">

                    <h3>

                        <i class="fas fa-user-lock"></i>

                        Login

                    </h3>

                </div>

                <div class="card-body">

                    <?php if($error!=""){ ?>

                        <div class="alert alert-danger">

                            <?php echo $error; ?>

                        </div>

                    <?php } ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label>Username</label>

                            <input type="text"
                                   name="username"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="mb-3">

                            <label>Password</label>

                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>

                        </div>

                        <button class="btn btn-primary w-100">

                            <i class="fas fa-sign-in-alt"></i>

                            Login

                        </button>

                    </form>

                    <hr>

                    <h6>Demo Login</h6>

                    <table class="table table-bordered">

                        <tr>
                            <th>Role</th>
                            <th>Username</th>
                            <th>Password</th>
                        </tr>

                        <tr>
                            <td>Admin</td>
                            <td>admin</td>
                            <td>admin123</td>
                        </tr>

                        <tr>
                            <td>Faculty</td>
                            <td>faculty</td>
                            <td>faculty123</td>
                        </tr>

                        <tr>
                            <td>Student</td>
                            <td>student</td>
                            <td>student123</td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>