<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\SetRoles;

use DegustaBox\Core\Domain\Messenger\Message\Command;

readonly class SetRolesCommand implements Command
{
    public function __construct(public string $id, public array $roles) {}
}