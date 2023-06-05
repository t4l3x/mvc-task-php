<?php

namespace App\Core\Notifications;

use App\Core\Services\SwiftMailerService;

class EmailNotifierFactory implements NotifierFactoryInterface
{
    public function createNotifier(): NotifierInterface
    {
        $mailer = new SwiftMailerService('mailpit', 1025, 'username', 'password');
        return new EmailNotifier($mailer);
    }
}