<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Domain\Entity;

use DateTime;
use DegustaBox\Auth\Domain\Entity\User;
use DegustaBox\Core\Domain\Exception\InvalidUuidException;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Domain\Exception\NotTrackingInProcessException;
use DegustaBox\TimeRecording\Domain\Exception\TrackingInProcessException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Task
{
    private User $user;

    /** @var Collection|Tracking[] $trackedTasks */
    protected Collection|array $trackedTasks;

    public function __construct(
        public readonly Uuid $id,
        public readonly string $name
    ) {
        $this->trackedTasks = new ArrayCollection();
    }

    public function totalTime(): int
    {
        $time = 0;
        foreach ($this->trackedTasks as $tracking) {
            $time += $tracking->time();
        }
        return $time;
    }

    public function todayTime(): int
    {
        $time = 0;
        foreach ($this->trackedTasks as $tracking) {
            $time += $tracking->todayTime();
        }
        return $time;
    }

    /**
     * @return Tracking[]
     */
    public function trackedTasks(): array
    {
        return $this->trackedTasks->toArray();
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @throws InvalidUuidException
     * @throws TrackingInProcessException
     */
    public function createTracking(DateTime $start, ?DateTime $end = null): void
    {
        if ($this->trackingInProgress() !== null) {
            throw new TrackingInProcessException();
        }

        if ($this->trackingEqualDates($start, $end) === null) {
            $tracking = new Tracking(Uuid::uuid4(), $start, $end);
            $tracking->setTask($this);
            $this->trackedTasks->add($tracking);
        }
    }

    /**
     * @throws NotTrackingInProcessException
     */
    public function closeTracking(DateTime $date): void
    {
        $tracking = $this->trackingInProgress();
        if ($tracking === null) {
            throw new NotTrackingInProcessException();
        }
        $tracking->setEnd($date);
    }

    private function trackingInProgress(): ?Tracking
    {
        foreach ($this->trackedTasks() as $tracking) {
            if ($tracking->end() == null) {
                return $tracking;
            }
        }

        return null;
    }

    private function trackingEqualDates(DateTime $start, ?DateTime $end = null): ?Tracking
    {
        foreach ($this->trackedTasks() as $tracking) {
            if ($tracking->start == $start && $tracking->end() == $end) {
                return $tracking;
            }
        }

        return null;
    }
}