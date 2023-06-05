<?php

namespace App\Core\Notifications;

use App\Core\Services\SomeSmsService;

/**
 * Class SmsNotifier
 *
 * SmsNotifier is responsible for sending SMS notifications.
 */
class SmsNotifier implements NotifierInterface
{
    public function __construct(private SomeSmsService $smsService) {}

    public function send(Notification $notification): void
    {
        if (!$notification instanceof SmsNotification) {
            throw new \InvalidArgumentException('Invalid notification type');
        }

        // Use $this->smsService to send an SMS
    }
}