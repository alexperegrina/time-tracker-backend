<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Domain\Entity;

use DateTime;
use DegustaBox\Core\Domain\ValueObject\Uuid;

class Tracking
{
    private Task $task;

    public function __construct(
        public readonly Uuid $id,
        public readonly DateTime $start,
        private ?DateTime $end = null,
    ) {}

    public function setTask(Task $task): void
    {
        $this->task = $task;
    }

    public function end(): ?DateTime
    {
        return $this->end;
    }

    public function setEnd(DateTime $end): void
    {
        $this->end = $end;
    }

    public function time(): int
    {
        if (null === $this->end) {
            return 0;
        }
        return $this->end->getTimestamp() - $this->start->getTimestamp();
    }

    public function todayTime(): int
    {
        $todayStart = new DateTime('today 00:00:00');
        $todayEnd = new DateTime('tomorrow 00:00:00');

        // Si el rango "init" y "end" no se solapan con el día de hoy, no hay segundos que contar
        if ($this->end < $todayStart || $this->start >= $todayEnd) {
            return 0;
        }

        // Ajustar "init" y "end" para que estén dentro del rango de hoy
        $initToday = max($this->start, $todayStart);
        $endToday = min($this->end, $todayEnd);

        // Calcular la diferencia en segundos
        $diff = $initToday->getTimestamp() - $endToday->getTimestamp();

        return abs($diff);
    }
}