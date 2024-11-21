<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Command\SetName;

use DegustaBox\Core\Domain\Messenger\Message\Command;

readonly class SetNameCommand implements Command
{
    public function __construct(
        public string  $id,
        public string  $firstName,
        public ?string $middleName = null,
        public ?string $lastName = null,
    ) {}
}