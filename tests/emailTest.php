<?php

require_once "../services/EmailService.php";

$email = new EmailService();

$result = $email->sendEmail(
    "tahavsbizz07@gmail.com",
    "Exam Reminder",
    "<h2>ExamShield LPS</h2>
     <p>Your exam is tomorrow at <b>10:00 AM</b>.</p>"
);

echo "<pre>";
print_r($result);
echo "</pre>";

?>