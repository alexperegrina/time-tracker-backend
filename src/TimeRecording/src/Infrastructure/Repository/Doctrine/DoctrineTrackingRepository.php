<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Infrastructure\Repository\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use DegustaBox\Core\Domain\Exception\EntityDuplicateException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\TimeRecording\Domain\Entity\Tracking;
use DegustaBox\TimeRecording\Domain\Repository\TrackingRepository;

class DoctrineTrackingRepository extends ServiceEntityRepository implements TrackingRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tracking::class);
    }

    public function save(Tracking $tracking): void
    {
        try {
            $this->getEntityManager()->persist($tracking);
            $this->getEntityManager()->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new EntityDuplicateException(Tracking::class);
        }
    }

    public function delete(Tracking $tracking): void
    {
        $this->getEntityManager()->remove($tracking);
        $this->getEntityManager()->flush();
    }

    public function findById(Uuid $id): Tracking
    {
        /** @var Tracking $tracking */
        $tracking = $this->getEntityManager()->getRepository(Tracking::class)->findOneBy(['id' => $id]);

        if (is_null($tracking)) {
            throw new EntityNotFoundByIdException(Tracking::class, $id->value);
        }

        return $tracking;
    }
}