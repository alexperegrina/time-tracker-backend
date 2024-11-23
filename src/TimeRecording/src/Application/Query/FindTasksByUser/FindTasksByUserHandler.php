<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Application\Query\FindTasksByUser;

use DegustaBox\Core\Domain\Messenger\Handler\QueryHandler;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Domain\Entity\Task;

readonly class FindTasksByUserHandler implements QueryHandler
{
    public function __construct(private FindTasksByUserService $service) {}

    /**
     * @return Task[]
     */
    public function __invoke(FindTasksByUserQuery $command): array
    {
        return $this->service->execute(Uuid::create($command->id));
    }
}