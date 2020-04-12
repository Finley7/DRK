<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event)
    {
        if($event->getRequest()->headers->get('Content-Type') == 'application/json') {
            $event->setResponse(new JsonResponse([
                'status' => 'error',
                'trace' => $_ENV['APP_ENV'] == 'dev' ? $event->getThrowable()->getTrace() : '',
                'message' => $event->getThrowable()->getMessage()
            ]));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
