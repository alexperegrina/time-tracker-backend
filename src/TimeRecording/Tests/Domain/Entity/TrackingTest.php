<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Tests\Domain\Entity;

use DateTime;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Domain\Entity\Tracking;
use DegustaBox\TimeRecording\Domain\Exception\InvalidDateRangeException;
use PHPUnit\Framework\TestCase;

class TrackingTest extends TestCase
{
    public function testTime(): void
    {
        $tracking = new Tracking(
            Uuid::uuid4(),
            new DateTime('2024-11-23T12:00:00.000Z'),
            new DateTime('2024-11-23T13:00:00.000Z')
        );

        $this->assertEquals(3600, $tracking->time());
    }

    public function testTotalTime(): void
    {
        $tracking = new Tracking(
            Uuid::uuid4(),
            new DateTime('2024-11-23T12:00:00.000Z'),
            new DateTime('2024-11-24T04:00:00.000Z')
        );

        $this->assertEquals(3600*4, $tracking->todayTime());
    }

    public function testGuardDates(): void
    {
        $this->expectException(InvalidDateRangeException::class);

        $tracking = new Tracking(
            Uuid::uuid4(),
            new DateTime('2024-11-23T14:00:00.000Z'),
            new DateTime('2024-11-23T12:00:00.000Z')
        );
    }
}