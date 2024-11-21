<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Domain\Exception;

use Exception;

class InvalidRoleException extends Exception
{
    public function __construct(string $role)
    {
        parent::__construct("Invalid role: $role");
    }
}