<?php

namespace App\Core\Notifications;

/**
 * Interface NotifierInterface
 *
 * NotifierInterface is the interface that all notifier classes must implement.
 */
interface NotifierInterface
{
    /**
     * Send a notification.
     *
     * @param Notification $notification
     */
    public function send(Notification $notification): void;

}