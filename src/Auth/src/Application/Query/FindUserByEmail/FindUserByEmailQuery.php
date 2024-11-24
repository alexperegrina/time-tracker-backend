<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Application\Query\FindUserByEmail;

use DegustaBox\Core\Domain\Messenger\Message\Query;

readonly class FindUserByEmailQuery implements Query
{
    public function __construct(public string $email) {}
}