<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Interfaces\Controller\Response\TaskController;

use DegustaBox\TimeRecording\Domain\Entity\Task;

readonly class TaskResponse
{
    public function __construct(public Task $task) {}

    public function response(): array
    {
        $timeTotal = $timeToday = 0;
        $tracking = [];

        foreach ($this->task->trackedTasks() as $trackedTask) {
            $tracking[] = [
                'id' => $trackedTask->id->value,
                'start' => $trackedTask->start->format(DATE_ATOM),
                'end' => $trackedTask->end()?->format(DATE_ATOM)
            ];

            $timeTotal += $trackedTask->time();
            $timeToday += $trackedTask->todayTime();
        }

        return [
            'id' => $this->task->id->value,
            'name' => $this->task->name,
            'tracking' => $tracking,
            'time' => [
                'total' => $timeTotal,
                'today' => $timeToday,
            ]
        ];
    }
}