<?php

namespace App\Core\Notifications;

interface NotifierFactoryInterface
{
    public function createNotifier(): NotifierInterface;
}
