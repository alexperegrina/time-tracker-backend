<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Application\Command\CreateTask;

use DateTime;
use DegustaBox\Core\Domain\Messenger\Handler\CommandHandler;
use DegustaBox\Core\Domain\ValueObject\Uuid;

readonly class CreateTaskHandler implements CommandHandler
{
    public function __construct(private CreateTaskService $service)
    {}

    public function __invoke(CreateTaskCommand $command): void
    {
        $this->service->execute(
            Uuid::create($command->userId),
            $command->name,
            new DateTime($command->start),
            $command->end != null ? new DateTime($command->end) : null,
        );
    }
}