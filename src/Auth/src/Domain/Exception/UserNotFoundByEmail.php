<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Domain\Exception;

use Exception;

class UserNotFoundByEmail extends Exception
{
    public function __construct(string $email)
    {
        parent::__construct("User not found by email: $email");
    }
}