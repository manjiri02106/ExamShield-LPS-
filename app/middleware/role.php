<?php

function checkRole($allowedRole)
{
    if ($_SESSION['role'] != $allowedRole) {

        echo "<h2>Access Denied</h2>";
        exit();

    }
}