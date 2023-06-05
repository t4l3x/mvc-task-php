<?php

namespace App\Services;

use App\Core\Notifications\EmailNotification;
use App\Core\Notifications\EmailNotifier;
use App\Core\Notifications\NotifierInterface;
use App\Core\Notifications\SmsNotification;
use App\Core\Notifications\SmsNotifier;


/**
 * Class NotificationService
 *
 * NotificationService encapsulates the logic for sending different types of notifications.
 */
class NotificationService
{
    private NotifierInterface $emailNotifier;
    private NotifierInterface $smsNotifier;

    public function __construct(NotifierInterface $emailNotifier, NotifierInterface $smsNotifier)
    {
        $this->emailNotifier = $emailNotifier;
        $this->smsNotifier = $smsNotifier;
    }

    public function sendEmail(string $from, string $to, string $subject, string $message): void
    {
        $emailNotification = new EmailNotification($from, $to, $subject, $message);
        $this->emailNotifier->send($emailNotification);
    }

    public function sendSms(string $from, string $to, string $message): void
    {
        $smsNotification = new SmsNotification($from, $to, $message);
        $this->smsNotifier->send($smsNotification);
    }

    public function sendEmailAndSms(string $emailFrom, string $emailTo, string $subject, string $emailMessage, string $smsFrom, string $smsTo, string $smsMessage): void
    {
        $this->sendEmail($emailFrom, $emailTo, $subject, $emailMessage);
        $this->sendSms($smsFrom, $smsTo, $smsMessage);
    }
}