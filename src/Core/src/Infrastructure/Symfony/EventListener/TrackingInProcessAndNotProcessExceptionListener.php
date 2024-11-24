<?php
declare(strict_types=1);

namespace DegustaBox\Core\Infrastructure\Symfony\EventListener;

use DegustaBox\TimeRecording\Domain\Exception\NotTrackingInProcessException;
use DegustaBox\TimeRecording\Domain\Exception\TrackingInProcessException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TrackingInProcessAndNotProcessExceptionListener implements EventSubscriberInterface
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

        if (!($exception instanceof TrackingInProcessException || $exception instanceof NotTrackingInProcessException)) {
            return;
        }

        $content = [
            'exception' => $exception::class,
            'code' => Response::HTTP_ACCEPTED,
            'message' => $exception->getMessage()
        ];

        $event->allowCustomResponseCode();
        $event->setResponse(new JsonResponse($content, Response::HTTP_ACCEPTED));
    }
}