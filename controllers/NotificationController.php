<?php

require_once __DIR__ . '/../services/NotificationService.php';

class NotificationController
{
    private $notificationService;

    public function __construct()
    {
        $this->notificationService = new NotificationService();
    }

    public function send($email, $subject, $message)
    {
        return $this->notificationService->sendNotification(
            $email,
            $subject,
            $message
        );
    }
}

?>
