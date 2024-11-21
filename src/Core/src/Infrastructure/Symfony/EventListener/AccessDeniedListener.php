<?php
declare(strict_types=1);

namespace DegustaBox\Core\Infrastructure\Symfony\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessDeniedListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 2],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof AccessDeniedException) {
            return;
        }

        // todo: esto se tiene que mejorar
        if (isset($exception->getAttributes()[0]) && $exception->getAttributes()[0] === 'IS_AUTHENTICATED_FULLY') {
            return;
        }

        $content = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
        ];

        $event->setResponse(new JsonResponse($content, $exception->getCode()));
    }
}