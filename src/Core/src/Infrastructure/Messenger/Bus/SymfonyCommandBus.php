<?php
declare(strict_types=1);

namespace DegustaBox\Core\Infrastructure\Messenger\Bus;

use DegustaBox\Core\Domain\Messenger\Bus\CommandBus;
use DegustaBox\Core\Domain\Messenger\Message\Command;

class SymfonyCommandBus extends SymfonyMessageBus implements CommandBus
{
    public function dispatch(Command $command): void
    {
        $this->dispatchMessage($command);
    }
}