<?php

require_once __DIR__ . '/EmailService.php';

class NotificationService
{
    private $emailService;

    public function __construct()
    {
        $this->emailService = new EmailService();
    }

    public function sendNotification($email, $subject, $message)
    {
        return $this->emailService->sendEmail(
            $email,
            $subject,
            $message
        );
    }
}

?>