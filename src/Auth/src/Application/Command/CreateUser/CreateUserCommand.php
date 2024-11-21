<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\CreateUser;

use DegustaBox\Core\Domain\Messenger\Message\Command;

readonly class CreateUserCommand implements Command
{
    public function __construct(
        public string $id,
        public string $email,
        public string $password
    ) {}
}