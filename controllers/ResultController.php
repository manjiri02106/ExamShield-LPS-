<?php

require_once __DIR__ . '/../services/NotificationService.php';

class ResultController
{
    private $notificationService;

    public function __construct()
    {
        $this->notificationService = new NotificationService();
    }

    public function sendResult($email, $studentName, $examName, $result, $marks)
    {
        $subject = "Exam Result Published";

        $message = "
        <h2>Exam Result Notification</h2>

        <p>Hello <b>$studentName</b>,</p>

        <p>Your examination result has been published.</p>

        <table border='1' cellpadding='8'>
            <tr>
                <td><b>Exam</b></td>
                <td>$examName</td>
            </tr>
            <tr>
                <td><b>Result</b></td>
                <td>$result</td>
            </tr>
            <tr>
                <td><b>Marks</b></td>
                <td>$marks</td>
            </tr>
        </table>

        <br>

        <p>Congratulations and Best Wishes!</p>

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