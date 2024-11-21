<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\Exception;

use Exception;

class InvalidUuidException extends Exception
{
    public function __construct(string $uuid)
    {
        parent::__construct("Invalid Uuid: $uuid");
    }
}