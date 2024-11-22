<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Domain\Repository;

use DegustaBox\Core\Domain\Exception\EntityDuplicateException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByArgumentsException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Domain\Entity\Task;

interface TaskRepository
{
    /**
     * @throws EntityDuplicateException
     */
    public function save(Task $task): void;
    public function delete(Task $task): void;

    /**
     * @throws EntityNotFoundByIdException
     */
    public function findById(Uuid $id): Task;

    /**
     * @throws EntityNotFoundByArgumentsException
     */
    public function findByName(Uuid $userId, string $name): Task;

    /**
     * @return Task[]
     */
    public function findByUserId(Uuid $id): array;
}