<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Application\Command\CreateTask;

use DateTime;
use DegustaBox\Auth\Domain\Repository\UserRepository;
use DegustaBox\Core\Domain\Exception\EntityDuplicateException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByArgumentsException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;
use DegustaBox\Core\Domain\Exception\InvalidUuidException;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Domain\Entity\Task;
use DegustaBox\TimeRecording\Domain\Exception\TrackingInProcessException;
use DegustaBox\TimeRecording\Domain\Repository\TaskRepository;

readonly class CreateTaskService
{
    public function __construct(
        private UserRepository $userRepository,
        private TaskRepository $taskRepository
    ) {}

    /**
     * @throws EntityNotFoundByIdException
     * @throws EntityDuplicateException
     * @throws TrackingInProcessException
     * @throws InvalidUuidException
     */
    public function execute(Uuid $userId, string $name, DateTime $start, ?DateTime $end = null): void
    {
        try {
            $task = $this->taskRepository->findByName($userId, $name);
        } catch (EntityNotFoundByArgumentsException) {
            $task = new Task(Uuid::uuid4(), $name);
            $user = $this->userRepository->findById($userId);
            $task->setUser($user);
        }

        $task->createTracking($start, $end);
        $this->taskRepository->save($task);
    }
}