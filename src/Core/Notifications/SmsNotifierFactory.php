<?php

namespace App\Core\Notifications;

class SmsNotifierFactory implements NotifierFactoryInterface
{
    public function createNotifier(): NotifierInterface
    {
        $smsService = new SomeSmsServiceProvider();
        return new SmsNotifier($smsService);
    }
}