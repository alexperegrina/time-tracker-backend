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
            new DateTime('today 12:00:00'),
            new DateTime('today 13:00:00')
        );

        $this->assertEquals(3600, $tracking->time());
    }

    public function testTodayTimeDow(): void
    {
        $tracking = new Tracking(
            Uuid::uuid4(),
            new DateTime('yesterday 23:00:00'),
            new DateTime('today 04:00:00')
        );

        $this->assertEquals(3600*4, $tracking->todayTime());
    }

    public function testTodayTimeUp(): void
    {
        $tracking = new Tracking(
            Uuid::uuid4(),
            new DateTime('today 23:00:00'),
            new DateTime('tomorrow 03:00:00')
        );

        $this->assertEquals(3600, $tracking->todayTime());
    }

    public function testGuardDates(): void
    {
        $this->expectException(InvalidDateRangeException::class);

        $tracking = new Tracking(
            Uuid::uuid4(),
            new DateTime('today 14:00:00'),
            new DateTime('today 12:00:00')
        );
    }
}