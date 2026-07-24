    <?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Set Success Message
|--------------------------------------------------------------------------
*/

function setSuccessMessage($message)
{
    $_SESSION['success_message'] = $message;
}

/*
|--------------------------------------------------------------------------
| Set Error Message
|--------------------------------------------------------------------------
*/

function setErrorMessage($message)
{
    $_SESSION['error_message'] = $message;
}

/*
|--------------------------------------------------------------------------
| Display Flash Message
|--------------------------------------------------------------------------
*/

function displayFlashMessage()
{
    if (isset($_SESSION['success_message'])) {

        echo "<div style='
                color:green;
                background:#d4edda;
                padding:10px;
                margin-bottom:15px;
                border:1px solid green;
              '>";

        echo htmlspecialchars($_SESSION['success_message']);

        echo "</div>";

        unset($_SESSION['success_message']);
    }

    if (isset($_SESSION['error_message'])) {

        echo "<div style='
                color:red;
                background:#f8d7da;
                padding:10px;
                margin-bottom:15px;
                border:1px solid red;
              '>";

        echo htmlspecialchars($_SESSION['error_message']);

        echo "</div>";

        unset($_SESSION['error_message']);
    }
}

?>