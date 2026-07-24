# ExamShield-LPS-

# ExamShield Notification Module

## Overview

A PHP-based email notification system for sending:

* General notifications
* Exam reminders
* Result announcements

## Technologies Used

* PHP 8
* MySQL
* PHPMailer
* Composer
* XAMPP

## Database

Database name: `examshield`

Tables:

* students
* exams
* results
* notifications
* reminders

## API Endpoints

### Send Notification

`/api/sendNotification.php`

### Exam Reminder

`/api/examReminderAPI.php`

### Result Notification

`/api/resultNotificationAPI.php`

## Email Service

Uses Gmail SMTP through PHPMailer.

## Features

* Sends HTML emails
* Uses MySQL data
* Returns JSON responses
* Secure SMTP configuration

## Author

Taha Yusuf Attarwala
