<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Tests\Domain\Entity;

use DateTime;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Domain\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testTotalTime(): void
    {
        $task = new Task(Uuid::uuid4(), 'task-1');
        $task->createTracking(new DateTime('today 08:00:00'), new DateTime('today 09:00:00'));
        $task->createTracking(new DateTime('today 10:00:00'), new DateTime('today 11:00:00'));

        $this->assertEquals(3600*2, $task->totalTime());
    }

    public function testTodayTime(): void
    {
        $task = new Task(Uuid::uuid4(), 'task-2');
        $task->createTracking(new DateTime('yesterday 23:00:00'), new DateTime('today 04:00:00')); // +4 hour
        $task->createTracking(new DateTime('today 06:00:00'), new DateTime('today 08:00:00')); // +2 hour
        $task->createTracking(new DateTime('today 23:00:00'), new DateTime('tomorrow 01:00:00')); // +1 hour

        $this->assertEquals(3600*7, $task->todayTime());
    }
}