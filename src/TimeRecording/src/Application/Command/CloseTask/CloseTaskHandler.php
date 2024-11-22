<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Application\Command\CloseTask;

use DateTime;
use DegustaBox\Core\Domain\Messenger\Handler\CommandHandler;
use DegustaBox\Core\Domain\ValueObject\Uuid;

readonly class CloseTaskHandler implements CommandHandler
{
    public function __construct(private CloseTaskService $service)
    {}

    public function __invoke(CloseTaskCommand $command): void
    {
        $this->service->execute(
            Uuid::create($command->userId),
            $command->name,
            new DateTime($command->end)
        );
    }
}