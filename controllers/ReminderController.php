<?php

require_once __DIR__ . '/../services/NotificationService.php';

class ReminderController
{
    private $notificationService;

    public function __construct()
    {
        $this->notificationService = new NotificationService();
    }

    public function sendReminder($email, $studentName, $examName, $examDate, $examTime)
    {
        $subject = "Exam Reminder";

        $message = "
        <h2>Exam Reminder</h2>

        <p>Hello <b>$studentName</b>,</p>

        <p>This is a reminder for your upcoming exam.</p>

        <table border='1' cellpadding='8'>
            <tr>
                <td><b>Exam</b></td>
                <td>$examName</td>
            </tr>
            <tr>
                <td><b>Date</b></td>
                <td>$examDate</td>
            </tr>
            <tr>
                <td><b>Time</b></td>
                <td>$examTime</td>
            </tr>
        </table>

        <br>

        <p>Best of Luck!</p>

        <p><b>ExamShield LPS Team</b></p>
        ";

        return $this->notificationService->sendNotification(
            $email,
            $subject,
            $message
        );
    }
}

?>