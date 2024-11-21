<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\AddRole;

use DegustaBox\Auth\Domain\Repository\UserRepository;
use DegustaBox\Auth\Domain\ValueObject\Enum\Role;
use DegustaBox\Core\Domain\Exception\EntityDuplicateException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;
use DegustaBox\Core\Domain\ValueObject\Uuid;

readonly class AddRoleService
{
    public function __construct(private UserRepository $userRepository)
    {}

    /**
     * @throws EntityDuplicateException
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $id, Role $role): void
    {
        $user = $this->userRepository->findById($id);

        $user->addRole($role);

        $this->userRepository->save($user);
    }
}