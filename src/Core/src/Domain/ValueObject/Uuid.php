<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\ValueObject;

use DegustaBox\Core\Domain\Exception\InvalidUuidException;
use Symfony\Component\Uid\Uuid as SymfonyUuid;

class Uuid extends StringValueObject
{
    /**
     * @throws InvalidUuidException
     */
    protected function __construct(string $value)
    {
        parent::__construct($value);
        $this->guardUuid($value);
    }

    /**
     * @throws InvalidUuidException
     */
    public static function create(string $value): self
    {
        return new self($value);
    }

    /**
     * @throws InvalidUuidException
     */
    public static function uuid4(): self
    {
        return new self(SymfonyUuid::v4()->jsonSerialize());
    }

    /**
     * @throws InvalidUuidException
     */
    private function guardUuid(string $value): void
    {
        if (!SymfonyUuid::isValid($value)) {
            throw new InvalidUuidException($value);
        }
    }
}