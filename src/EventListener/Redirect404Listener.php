<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class Redirect404Listener implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof NotFoundHttpException) {
            $response = new RedirectResponse('/page-404');
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents()
    {
        //Must be register with an hight priority to be execut before the error featrues
        return [
            KernelEvents::EXCEPTION => [['onKernelException', 100]],
        ];
    }
}
