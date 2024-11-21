<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\CreateUser;

use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\Auth\Domain\Entity\User;
use DegustaBox\Auth\Domain\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class CreateUserService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function execute(Uuid $id, string $email, string $password): void
    {
        $user = User::create($id, $email, $password);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user);
    }
}