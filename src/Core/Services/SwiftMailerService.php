<?php
namespace App\Core\Services;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class SwiftMailerService
{
    private Mailer $mailer;

    public function __construct(string $smtpHost, int $smtpPort, string $username, string $password)
    {
        // Create the Transport
        $transport = Transport::fromDsn("smtp://$username:$password@$smtpHost:$smtpPort");


        // Create the Mailer using your created Transport
        $this->mailer =  new Mailer($transport);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(string $from, string $to, string $subject, string $body): void
    {

        // Create a message
        $message = (new Email())
            ->from($from)
            ->to($to)
            ->text($body)
            ->subject($subject);

        // Send the message
        $this->mailer->send($message);
    }
}