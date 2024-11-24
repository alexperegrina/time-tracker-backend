<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Application\Query\FindTaskById;

use DegustaBox\Core\Domain\Messenger\Handler\QueryHandler;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Domain\Entity\Task;

readonly class FindTaskByIdHandler implements QueryHandler
{
    public function __construct(private FindTaskByIdService $service)
    {}

    public function __invoke(FindTaskByIdQuery $command): Task
    {
        return $this->service->execute(Uuid::create($command->id));
    }
}