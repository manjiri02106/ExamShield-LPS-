<?php
require_once __DIR__ . '/../controllers/ReminderController.php';

$reminder = new ReminderController();

$result = $reminder->sendReminder(
    'tahavsbizz07@gmail.com',   // Replace with the student's email
    'Taha Attarwala',              // Replace with the student's name
    'Mathematics',           // Replace with the exam name
    '2026-07-30',            // Replace with the exam date
    '10:00 AM'               // Replace with the exam time
);

if ($result) {
    echo "Exam reminder sent successfully.";
} else {
    echo "Failed to send exam reminder.";
}
?>