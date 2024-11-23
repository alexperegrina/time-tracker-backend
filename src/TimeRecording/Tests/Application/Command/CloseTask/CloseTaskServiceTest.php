<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Tests\Application\Command\CloseTask;

use DateTime;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Application\Command\CloseTask\CloseTaskService;
use DegustaBox\TimeRecording\Application\Command\CreateTask\CreateTaskService;
use DegustaBox\TimeRecording\Domain\Exception\NotTrackingInProcessException;
use DegustaBox\TimeRecording\Domain\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CloseTaskServiceTest extends WebTestCase
{
    private CreateTaskService $createTaskService;
    private CloseTaskService $closeTaskService;
    private TaskRepository $taskRepository;
    private Uuid $userId;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->createTaskService = $container->get(CreateTaskService::class);
        $this->closeTaskService = $container->get(CloseTaskService::class);
        $this->taskRepository = $container->get(TaskRepository::class);

        $this->userId = Uuid::create('d398a9b5-cb0d-450d-8e8e-0692a81aa951');
    }

    public function testClose(): void
    {
        $this->createTaskService->execute($this->userId, 'task-test-3', new DateTime());

        $task = $this->taskRepository->findByName($this->userId, 'task-test-3');
        $this->assertNull($task->trackedTasks()[0]->end());

        $this->closeTaskService->execute($this->userId, 'task-test-3', new DateTime());
        $task = $this->taskRepository->findByName($this->userId, 'task-test-3');
        $this->assertNotNull($task->trackedTasks()[0]->end());
    }

    public function testNotTaskInProcessException(): void
    {
        $this->createTaskService->execute($this->userId, 'task-test-4', new DateTime(), new DateTime());

        $this->expectException(NotTrackingInProcessException::class);
        $this->closeTaskService->execute($this->userId, 'task-test-4', new DateTime());
    }
}