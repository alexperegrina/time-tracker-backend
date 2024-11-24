<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Interfaces\Controller\Response\TaskController;

readonly class ListResponse
{
    public function __construct(public array $tasks) {}

    public function response(): array
    {
        $response = [];
        foreach ($this->tasks as $task) {
            $taskResponse = new TaskResponse($task);
            $response[] = $taskResponse->response();
        }

        return ['tasks' => $response];
    }
}