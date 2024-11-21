<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\ValueObject;

use DegustaBox\Core\Domain\Exception\InvalidNativeArgumentException;

class StringValueObject extends AbstractValueObject
{
    protected function __construct(public readonly string $value)
    {
        $this->guard($value);
    }

    public static function create(string $value): self {
        return new static($value);
    }

    protected function guard(string $value): void
    {
        if (false === is_string($value)) {
            throw new InvalidNativeArgumentException($value, ['string']);
        }
    }

    protected function equalValues(AbstractValueObject|StringValueObject $object): bool
    {
        return $this->value === $object->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}