<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Infrastructure\Repository\Doctrine;

use DegustaBox\Core\Domain\Exception\EntityDuplicateException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByArgumentsException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Domain\Entity\Task;
use DegustaBox\TimeRecording\Domain\Repository\TaskRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineTaskRepository extends ServiceEntityRepository implements TaskRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function save(Task $task): void
    {
        try {
            $this->getEntityManager()->persist($task);
            $this->getEntityManager()->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new EntityDuplicateException(Task::class);
        }
    }

    public function delete(Task $task): void
    {
        $this->getEntityManager()->remove($task);
        $this->getEntityManager()->flush();
    }

    public function findById(Uuid $id): Task
    {
        /** @var Task $task */
        $task = $this->getEntityManager()->getRepository(Task::class)->findOneBy(['id' => $id]);

        if (is_null($task)) {
            throw new EntityNotFoundByIdException(Task::class, $id->value);
        }

        return $task;
    }

    public function findByName(Uuid $userId, string $name): Task
    {
        /** @var Task $task */
        $task = $this->getEntityManager()->getRepository(Task::class)->findOneBy(['name' => $name, 'user' => $userId]);

        if (is_null($task)) {
            throw new EntityNotFoundByArgumentsException(Task::class, 'name', $name);
        }

        return $task;
    }

    public function findByUserId(Uuid $id): array
    {
        return $this->getEntityManager()->getRepository(Task::class)->findBy(['user' => $id]);
    }
}