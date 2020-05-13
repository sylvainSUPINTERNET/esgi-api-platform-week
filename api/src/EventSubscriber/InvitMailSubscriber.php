<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Invit;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class InvitMailSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['sendMail', EventPriorities::POST_WRITE],
        ];
    }

    public function sendMail(ViewEvent $event): void
    {
        $invit = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$invit instanceof Invit || Request::METHOD_POST !== $method) {
            return;
        }

        $message = (new Swift_Message('Votre candidature intéresse !'))
            ->setFrom('sylvain.joly00@gmail.com')
            ->setTo($invit->getEmail())
            ->setBody(sprintf('Code recruiter : %s.', $invit->getToken()));

        $this->mailer->send($message);
    }
}
