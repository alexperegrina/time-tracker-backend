<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\VerifyUser;

use DegustaBox\Core\Domain\Exception\EntityDuplicateException;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\Auth\Domain\Repository\UserRepository;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;

readonly class VerifyUserService
{
    public function __construct(private UserRepository $userRepository)
    {}

    /**
     * @throws EntityNotFoundByIdException|EntityDuplicateException
     */
    public function execute(Uuid $id): void
    {
        $user = $this->userRepository->findById($id);
        $user->verify();
        $this->userRepository->save($user);
    }
}