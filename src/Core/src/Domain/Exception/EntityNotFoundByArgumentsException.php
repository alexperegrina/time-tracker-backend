<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\Exception;

use Exception;

class EntityNotFoundByArgumentsException extends Exception
{
    public function __construct(string $entity, string $nameArgument, string $argument)
    {
        parent::__construct("Entity: '$entity' not found by $nameArgument: $argument");
    }
}