<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Tests\Application\Command\CreateTask;

use DateTime;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Application\Command\CreateTask\CreateTaskService;
use DegustaBox\TimeRecording\Domain\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateTaskServiceTest extends WebTestCase
{
    private CreateTaskService $createTaskService;
    private TaskRepository $taskRepository;
    private Uuid $userId;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->createTaskService = $container->get(CreateTaskService::class);
        $this->taskRepository = $container->get(TaskRepository::class);

        $this->userId = Uuid::create('d398a9b5-cb0d-450d-8e8e-0692a81aa951');
    }

    public function testCreateComplete(): void
    {
        $this->createTaskService->execute($this->userId, 'task-test-1', new DateTime(), new DateTime());

        $task = $this->taskRepository->findByName($this->userId, 'task-test-1');
        $this->assertNotNull($task->trackedTasks()[0]->start);
        $this->assertNotNull($task->trackedTasks()[0]->end());
    }

    public function testCreateIncomplete(): void
    {
        $this->createTaskService->execute($this->userId, 'task-test-2', new DateTime());

        $task = $this->taskRepository->findByName($this->userId, 'task-test-2');
        $this->assertNotNull($task->trackedTasks()[0]->start);
        $this->assertNull($task->trackedTasks()[0]->end());
    }

    public function testCreateTwoTaskEqualName(): void
    {
        $this->createTaskService->execute($this->userId, 'task-test-1', new DateTime(), new DateTime());
        $this->createTaskService->execute($this->userId, 'task-test-1', new DateTime(), new DateTime());

        $task = $this->taskRepository->findByName($this->userId, 'task-test-1');
        $this->assertCount(2, $task->trackedTasks());
    }
}