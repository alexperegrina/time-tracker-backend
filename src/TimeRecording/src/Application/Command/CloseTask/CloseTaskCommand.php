<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Application\Command\CloseTask;

use DegustaBox\Core\Domain\Messenger\Message\Command;

readonly class CloseTaskCommand implements Command
{
    public function __construct(public string $userId, public string $name, public string $end)
    {}
}