<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\SetName;

use DegustaBox\Core\Domain\ValueObject\Name;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\Auth\Domain\Repository\UserRepository;
use DegustaBox\Core\Domain\Exception\EntityDuplicateException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;

readonly class SetNameService
{
    public function __construct(private UserRepository $userRepository)
    {}

    /**
     * @throws EntityDuplicateException
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $id, Name $name): void
    {
        $user = $this->userRepository->findById($id);

        $user->setName($name);

        $this->userRepository->save($user);
    }
}