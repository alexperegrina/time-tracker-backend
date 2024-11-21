<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\Messenger\Bus;

use DegustaBox\Core\Domain\Messenger\Message\Command;

interface CommandBus extends MessageBus
{
    public function dispatch(Command $command): void;
}