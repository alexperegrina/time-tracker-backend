<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\CreateUser;

use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\Auth\Domain\Entity\User;
use DegustaBox\Auth\Domain\Repository\UserRepository;

readonly class CreateUserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function execute(Uuid $id, string $email, string $password): void
    {
        $user = User::create($id, $email, $password);
        $user->setPassword($password);

        $this->userRepository->save($user);
    }
}