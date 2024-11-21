<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\SetGender;

use DegustaBox\Core\Domain\Messenger\Message\Command;

readonly class SetGenderCommand implements Command
{
    public function __construct(public string $id, public string $gender) {}
}