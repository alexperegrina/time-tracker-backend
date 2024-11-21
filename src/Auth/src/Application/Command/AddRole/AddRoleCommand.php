<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\AddRole;

use DegustaBox\Core\Domain\Messenger\Message\Command;

readonly class AddRoleCommand implements Command
{
    public function __construct(public string $id, public string $role) {}
}