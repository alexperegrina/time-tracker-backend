<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\ValueObject;

class Name extends AbstractValueObject
{
    protected function __construct(
        public readonly StringValueObject $firstName,
        public readonly ?StringValueObject $middleName = null,
        public readonly ?StringValueObject $lastName = null,
    ) {}

    public static function create(
        StringValueObject $firstName,
        ?StringValueObject $middleName = null,
        ?StringValueObject $lastName = null,
    ): self {
        return new self($firstName, $middleName, $lastName);
    }

    public function fullName(): StringValueObject
    {
        return StringValueObject::create($this->firstName->value.' '.$this->middleName?->value.' '.$this->lastName?->value);
    }

    protected function equalValues(AbstractValueObject|Name $object): bool
    {
        return $this->fullName()->equals($object->fullName());
    }
}