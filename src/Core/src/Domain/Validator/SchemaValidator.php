<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\Validator;

use DegustaBox\Core\Domain\Exception\InvalidPathException;
use DegustaBox\Core\Domain\Exception\SchemaValidatorException;

interface SchemaValidator
{
    /**
     * @throws SchemaValidatorException
     * @throws InvalidPathException
     */
    public function validate(object|array $data, string $pathSchema, bool $exception = true): object|array;
}