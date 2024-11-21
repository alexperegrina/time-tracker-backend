<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\DeleteUser;

use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\Auth\Domain\Repository\UserRepository;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;

readonly class DeleteUserService
{
    public function __construct(private UserRepository $userRepository)
    {}

    /**
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $id): void
    {
        $user = $this->userRepository->findById($id);
        $this->userRepository->delete($user);
    }
}