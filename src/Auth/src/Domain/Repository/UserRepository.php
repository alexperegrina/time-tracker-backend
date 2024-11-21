<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Domain\Repository;

use DegustaBox\Auth\Domain\Entity\User;
use DegustaBox\Auth\Domain\Exception\UserNotFoundByEmail;
use DegustaBox\Core\Domain\Exception\EntityDuplicateException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;
use DegustaBox\Core\Domain\ValueObject\Uuid;

interface UserRepository
{
    /**
     * @throws EntityDuplicateException
     */
    public function save(User $user): void;
    public function delete(User $user): void;

    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @throws EntityNotFoundByIdException
     */
    public function findById(Uuid $id): User;

    /**
     * @throws UserNotFoundByEmail
     */
    public function findByEmail(string $email): User;

    /**
     * @return User[]
     */
    public function findByRole(string $role): array;
}