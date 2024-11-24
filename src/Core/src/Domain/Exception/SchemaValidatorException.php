<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\Exception;

use Exception;

class SchemaValidatorException extends Exception
{
    public function __construct(public readonly array $errors, public readonly array $data)
    {
        parent::__construct("Schema validation failed");
    }
}