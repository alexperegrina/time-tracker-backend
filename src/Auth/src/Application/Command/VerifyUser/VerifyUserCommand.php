<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\VerifyUser;

use DegustaBox\Core\Domain\Messenger\Message\Command;

readonly class VerifyUserCommand implements Command
{
    public function __construct(public string $id)
    {}
}