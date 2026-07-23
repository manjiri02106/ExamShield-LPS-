<?php

$localConfig = __DIR__ . '/../mail.local.php';

if (file_exists($localConfig)) {
    return require $localConfig;
}

return [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'username' => 'your_email@gmail.com',
    'password' => 'your_app_password',
    'from_email' => 'your_email@gmail.com',
    'from_name' => 'ExamShield LPS'
];

?>