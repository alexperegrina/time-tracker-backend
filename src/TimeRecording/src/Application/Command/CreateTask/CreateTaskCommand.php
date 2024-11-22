<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Application\Command\CreateTask;

use DegustaBox\Core\Domain\Messenger\Message\Command;

readonly class CreateTaskCommand implements Command
{
    public function __construct(
        public string $userId,
        public string $name,
        public string $start,
        public ?string $end = null
    ) {}
}