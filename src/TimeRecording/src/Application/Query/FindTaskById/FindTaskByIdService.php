<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Application\Query\FindTaskById;

use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Domain\Entity\Task;
use DegustaBox\TimeRecording\Domain\Repository\TaskRepository;

readonly class FindTaskByIdService
{
    public function __construct(private TaskRepository $taskRepository) {}

    /**
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $id): Task
    {
        return $this->taskRepository->findById($id);
    }
}