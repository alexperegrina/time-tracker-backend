<?php
declare(strict_types=1);

namespace DegustaBox\Core\Infrastructure\Symfony\EventListener;

use DegustaBox\Core\Domain\Exception\SchemaValidatorException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SchemaValidatorExceptionListener implements EventSubscriberInterface
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

        if (!$exception instanceof SchemaValidatorException) {
            return;
        }

        $content = [
            'exception' => SchemaValidatorException::class,
            'code' => Response::HTTP_BAD_REQUEST,
            'message' => $exception->getMessage(),
            'errors' => $exception->errors
        ];

        $event->setResponse(new JsonResponse($content, Response::HTTP_BAD_REQUEST));
    }
}