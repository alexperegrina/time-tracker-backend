<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Application\Query\FindTasksByUser;

use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Domain\Entity\Task;
use DegustaBox\TimeRecording\Domain\Repository\TaskRepository;

readonly class FindTasksByUserService
{
    public function __construct(private TaskRepository $taskRepository) {}

    /**
     * @return Task[]
     */
    public function execute(Uuid $id): array
    {
        return $this->taskRepository->findByUserId($id);
    }
}