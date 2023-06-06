<?php

namespace App\Core\Notifications;

use App\Core\Services\SwiftMailerService;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

/**
 * Class EmailNotifier
 *
 * EmailNotifier is responsible for sending email notifications.
 */
readonly class EmailNotifier implements NotifierInterface
{
    public function __construct(private SwiftMailerService $mailer) {}

    /**
     * @throws TransportExceptionInterface
     */
    public function send(Notification $notification): void
    {
        if (!$notification instanceof EmailNotification) {
            throw new \InvalidArgumentException('Invalid notification type');
        }

        $this->mailer->send(
            $notification->getFrom(),
            $notification->getTo(),
            $notification->getSubject(),
            $notification->getMessage()
        );
    }
}
