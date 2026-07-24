<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

class EmailService
{
    private $mailConfig;

    public function __construct()
    {
        $this->mailConfig = require __DIR__ . '/../config/mail.php';
    }

    public function sendEmail($to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // SMTP Settings
            $mail->isSMTP();
            $mail->Host       = $this->mailConfig['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->mailConfig['username'];
            $mail->Password   = $this->mailConfig['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $this->mailConfig['port'];

            // Sender & Receiver
            $mail->setFrom(
                $this->mailConfig['from_email'],
                $this->mailConfig['from_name']
            );

            $mail->addAddress($to);

            // Email Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();

            return [
                "status" => true,
                "message" => "Email sent successfully."
            ];

        } catch (Exception $e) {

            return [
                "status" => false,
                "message" => $mail->ErrorInfo
            ];
        }
    }
}

?>
