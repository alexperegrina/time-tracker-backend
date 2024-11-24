<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Query\FindUserByEmail;

use DegustaBox\Auth\Domain\Entity\User;
use DegustaBox\Auth\Domain\Exception\UserNotFoundByEmail;
use DegustaBox\Auth\Domain\Repository\UserRepository;

readonly class FindUserByEmailService
{
    public function __construct(private UserRepository $userRepository) {}

    /**
     * @throws UserNotFoundByEmail
     */
    public function execute(string $email): User
    {
        return $this->userRepository->findByEmail($email);
    }
}