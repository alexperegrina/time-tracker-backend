<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\SetRoles;

use DegustaBox\Auth\Domain\ValueObject\Enum\Role;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\Auth\Domain\Repository\UserRepository;
use DegustaBox\Core\Domain\Exception\EntityDuplicateException;
use DegustaBox\Core\Domain\Exception\EntityNotFoundByIdException;

readonly class SetRolesService
{
    public function __construct(private UserRepository $userRepository)
    {}

    /**
     * @param Uuid $id
     * @param Role[] $roles
     * @throws EntityDuplicateException
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $id, array $roles): void
    {
        $user = $this->userRepository->findById($id);

        foreach ($roles as $role) {
            $user->addRole($role);
        }

        $this->userRepository->save($user);
    }
}