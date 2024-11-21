<?php
declare(strict_types=1);

namespace DegustaBox\Core\Infrastructure\Messenger\Bus;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use DegustaBox\Core\Domain\Messenger\Bus\MessageBus;
use DegustaBox\Core\Domain\Messenger\Message\Command;
use DegustaBox\Core\Domain\Messenger\Message\Query;
use Throwable;

abstract class SymfonyMessageBus implements MessageBus
{
    use HandleTrait;

    protected array $messages;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
        $this->messages = [];
    }

    public function messages(): array
    {
        return $this->messages;
    }

    /**
     * @throws Throwable
     */
    protected function dispatchMessage(Command|Query $message): mixed
    {
        $this->messages[] = $message;
        try {
            return $this->handle($message);
        } catch (HandlerFailedException $e) {
            while ($e instanceof HandlerFailedException) {
                /** @var Throwable $e */
                $e = $e->getPrevious();
            }
            throw $e;
        }
    }
}