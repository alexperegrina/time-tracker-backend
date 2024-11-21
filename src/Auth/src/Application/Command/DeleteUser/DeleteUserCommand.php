<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\DeleteUser;

use DegustaBox\Core\Domain\Messenger\Message\Command;

readonly class DeleteUserCommand implements Command
{
    public function __construct(public string $id)
    {}
}