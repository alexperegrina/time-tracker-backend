<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\AddRole;

use DegustaBox\Auth\Domain\ValueObject\Enum\Role;
use DegustaBox\Core\Domain\Messenger\Handler\CommandHandler;
use DegustaBox\Core\Domain\ValueObject\Uuid;

readonly class AddRoleHandler implements CommandHandler
{
    public function __construct(private AddRoleService $service)
    {}

    public function __invoke(AddRoleCommand $command): void
    {
        $this->service->execute(Uuid::create($command->id), Role::from($command->role));
    }
}