<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Application\Command\CloseTask;

use DateTime;
use DegustaBox\Core\Domain\Exception\EntityDuplicateException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByArgumentsException;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Domain\Exception\NotTrackingInProcessException;
use DegustaBox\TimeRecording\Domain\Repository\TaskRepository;

readonly class CloseTaskService
{
    public function __construct(private TaskRepository $taskRepository)
    {}

    /**
     * @throws EntityNotFoundByArgumentsException
     * @throws EntityDuplicateException
     * @throws NotTrackingInProcessException
     */
    public function execute(Uuid $userId, string $name, DateTime $end): void
    {
        $task = $this->taskRepository->findByName($userId, $name);
        $task->closeTracking($end);
        $this->taskRepository->save($task);
    }
}