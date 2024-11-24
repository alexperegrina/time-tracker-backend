<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Infrastructure\Symfony\EventListener;

use DegustaBox\TimeRecording\Domain\Exception\InvalidDateRangeException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class InvalidDateRangeExceptionListener implements EventSubscriberInterface
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

        if (!$exception instanceof InvalidDateRangeException) {
            return;
        }

        $content = [
            'exception' => $exception::class,
            'code' => Response::HTTP_CONFLICT,
            'message' => $exception->getMessage()
        ];

        $event->allowCustomResponseCode();
        $event->setResponse(new JsonResponse($content, Response::HTTP_CONFLICT));
    }
}