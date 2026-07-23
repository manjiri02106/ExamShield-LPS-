<?php

echo "<h2>API Testing</h2>";

$apis = [
    "Notification API" => "http://localhost/ExamShield-LPS-/api/sendNotification.php",
    "Exam Reminder API" => "http://localhost/ExamShield-LPS-/api/examReminderAPI.php",
    "Result Notification API" => "http://localhost/ExamShield-LPS-/api/resultNotificationAPI.php"
];

foreach ($apis as $name => $url) {
    echo "<h3>Testing: $name</h3>";

    $response = @file_get_contents($url);

    if ($response !== false) {
        echo "<pre>$response</pre>";
    } else {
        echo "<p style='color:red;'>Failed to call API.</p>";
    }

    echo "<hr>";
}

?>