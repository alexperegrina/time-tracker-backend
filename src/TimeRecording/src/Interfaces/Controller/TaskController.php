<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Interfaces\Controller;

use DegustaBox\Auth\Domain\Entity\User;
use DegustaBox\Core\Domain\Messenger\Bus\CommandBus;
use DegustaBox\Core\Domain\Messenger\Bus\QueryBus;
use DegustaBox\TimeRecording\Application\Command\CloseTask\CloseTaskCommand;
use DegustaBox\TimeRecording\Application\Command\CreateTask\CreateTaskCommand;
use DegustaBox\TimeRecording\Domain\Exception\NotTrackingInProcessException;
use DegustaBox\TimeRecording\Domain\Exception\TrackingInProcessException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class TaskController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus, private readonly QueryBus $queryBus) {}

    #[Route('/create', name: 'time-recording_create', methods: ['POST'])]
    public function create(#[CurrentUser] ?User $user, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new CreateTaskCommand(
            $user->id->value,
            $data['name'],
            $data['start'],
            $data['end'] ?? null
        );

        try {
            $this->commandBus->dispatch($command);
            return $this->json([], 201);
        } catch (TrackingInProcessException $e) {
            return $this->json(["message" => $e->getMessage()], 202);
        }
    }

    #[Route('/close', name: 'time-recording_close', methods: ['POST'])]
    public function close(#[CurrentUser] ?User $user, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new CloseTaskCommand($user->id->value, $data['name'], $data['end']);

        try {
            $this->commandBus->dispatch($command);
            return $this->json([], 201);
        } catch (NotTrackingInProcessException $e) {
            return $this->json(["message" => $e->getMessage()], 202);
        }
    }
}