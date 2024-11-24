<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Interfaces\Controller;

use DegustaBox\Auth\Domain\Entity\User;
use DegustaBox\Core\Domain\Messenger\Bus\CommandBus;
use DegustaBox\Core\Domain\Messenger\Bus\QueryBus;
use DegustaBox\Core\Domain\Validator\SchemaValidator;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Application\Command\CloseTask\CloseTaskCommand;
use DegustaBox\TimeRecording\Application\Command\CreateTask\CreateTaskCommand;
use DegustaBox\TimeRecording\Application\Query\FindTaskById\FindTaskByIdQuery;
use DegustaBox\TimeRecording\Application\Query\FindTasksByUser\FindTasksByUserQuery;
use DegustaBox\TimeRecording\Interfaces\Controller\Response\TaskController\ListResponse;
use DegustaBox\TimeRecording\Interfaces\Controller\Response\TaskController\TaskResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class TaskController extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly QueryBus $queryBus,
        private readonly SchemaValidator $schemaValidator
    ) {}

    #[Route('/create', name: 'time-recording_create', methods: ['POST'])]
    public function create(#[CurrentUser] ?User $user, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $data = $this->schemaValidator->validate(
            $data,
            '@TimeRecordingBundle/Resources/schema/Interfaces/Controller/TaskController/Request/create.json'
        );

        $command = new CreateTaskCommand(
            $user->id->value,
            $data['name'],
            $data['start'],
            $data['end'] ?? null
        );

        $this->commandBus->dispatch($command);
        return $this->json([], 201);
    }

    #[Route('/close', name: 'time-recording_close', methods: ['POST'])]
    public function close(#[CurrentUser] ?User $user, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $data = $this->schemaValidator->validate(
            $data,
            '@TimeRecordingBundle/Resources/schema/Interfaces/Controller/TaskController/Request/close.json'
        );

        $command = new CloseTaskCommand($user->id->value, $data['name'], $data['end']);

        $this->commandBus->dispatch($command);
        return $this->json([], 201);
    }

    #[Route('/list', name: 'time-recording_list', methods: ['GET'])]
    public function list(#[CurrentUser] ?User $user): JsonResponse
    {
        $query = new FindTasksByUserQuery($user->id->value);
        $tasks = $this->queryBus->dispatch($query);
        $response = new ListResponse($tasks);

        return $this->json($response->response());
    }

    #[Route('/{id}', name: 'time-recording_task-by-id', requirements: ['id' => '%routing.uuid%'], methods: ['GET'])]
    public function taskById(#[CurrentUser] ?User $user, string $id): JsonResponse
    {
        $query = new FindTaskByIdQuery($id);
        $task = $this->queryBus->dispatch($query);
        $response = new TaskResponse($task);

        return $this->json($response->response());
    }
}