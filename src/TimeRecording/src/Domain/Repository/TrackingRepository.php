<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Domain\Repository;

use DegustaBox\Core\Domain\Exception\EntityDuplicateException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Domain\Entity\Tracking;

interface TrackingRepository
{
    /**
     * @throws EntityDuplicateException
     */
    public function save(Tracking $tracking): void;
    public function delete(Tracking $tracking): void;

    /**
     * @throws EntityNotFoundByIdException
     */
    public function findById(Uuid $id): Tracking;
}