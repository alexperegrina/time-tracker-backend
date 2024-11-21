<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\Exception;

use Exception;

class EntityNotFoundByIdException extends Exception
{
    public function __construct(string $entity, string $id)
    {
        parent::__construct("Entity: '$entity' not found by id: $id");
    }
}