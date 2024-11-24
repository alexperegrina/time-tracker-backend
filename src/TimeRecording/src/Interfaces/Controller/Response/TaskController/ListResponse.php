<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Interfaces\Controller\Response\TaskController;

use DegustaBox\TimeRecording\Domain\Entity\Task;

readonly class ListResponse
{
    public function __construct(public array $tasks) {}

    public function response(): array
    {
        $taskResponse = [];
        foreach ($this->tasks as $task) {
            $taskResponse[] = $this->taskResponse($task);
        }

        return ['tasks' => $taskResponse];
    }

    private function taskResponse(Task $task): array
    {
        $timeTotal = $timeToday = 0;

        $tracking = [];

        foreach ($task->trackedTasks() as $trackedTask) {
            $tracking[] = [
                'id' => $trackedTask->id->value,
                'start' => $trackedTask->start->format(DATE_ATOM),
                'end' => $trackedTask->end()?->format(DATE_ATOM)
            ];

            $timeTotal += $trackedTask->time();
            $timeToday += $trackedTask->todayTime();
        }

        return [
            'id' => $task->id->value,
            'name' => $task->name,
            'tracking' => $tracking,
            'time' => [
                'total' => $timeTotal,
                'today' => $timeToday,
            ]
        ];
    }
}