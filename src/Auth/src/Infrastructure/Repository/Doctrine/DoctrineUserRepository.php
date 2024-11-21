<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Infrastructure\Repository\Doctrine;

use DegustaBox\Core\Domain\Exception\EntityDuplicateException;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use DegustaBox\Auth\Domain\Entity\User;
use DegustaBox\Auth\Domain\Exception\UserNotFoundByEmail;
use DegustaBox\Auth\Domain\Repository\UserRepository;
//use DegustaBox\Core\Domain\ValueObject\Criteria;
use DegustaBox\Core\Domain\ValueObject\Uuid;
//use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
//use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
//use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        try {
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new EntityDuplicateException(User::class);
        }
    }

    public function delete(User $user): void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    public function findById(Uuid $id): User
    {
        if ($this->getEntityManager()->getFilters()->isEnabled('soft_deleteable')) {
            $this->getEntityManager()->getFilters()->disable('soft_deleteable');
        }

        /** @var User $user */
        $user = $this->getEntityManager()->getRepository(User::class)->findOneBy(['id' => $id]);

        if (is_null($user)) {
            throw new EntityNotFoundByIdException(User::class, $id->value);
        }

        return $user;
    }

    public function findByEmail(string $email): User
    {
        /** @var User $user */
        $user = $this->getEntityManager()->getRepository(User::class)->findOneBy(['email' => $email]);

        if (is_null($user)) {
            throw new UserNotFoundByEmail($email);
        }

        return $user;
    }

    public function findByRole(string $role): array
    {
        $role = mb_strtoupper($role);

        return $this->createQueryBuilder('u')
            ->andWhere('JSON_CONTAINS(u.roles, :role) = 1')
            ->setParameter('role', '"'.$role.'"')
            ->getQuery()
            ->getResult();
    }
}