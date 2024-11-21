<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\SetRoles;

use DegustaBox\Auth\Domain\ValueObject\Enum\Role;
use DegustaBox\Core\Domain\ValueObject\Uuid;
use DegustaBox\Core\Domain\Messenger\Handler\CommandHandler;

readonly class SetRolesHandler implements CommandHandler
{
    public function __construct(private SetRolesService $service)
    {}

    public function __invoke(SetRolesCommand $command): void
    {
        $roles = [];
        foreach ($command->roles as $role) {
            $roles[] = Role::from($role);
        }
        $this->service->execute(Uuid::create($command->id), $roles);
    }
}