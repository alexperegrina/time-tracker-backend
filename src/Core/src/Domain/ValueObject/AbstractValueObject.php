<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\ValueObject;

abstract class AbstractValueObject
{
    public function equals(self $object): bool
    {
        return self::classEquals($this, $object) && $this->equalValues($object);
    }

    abstract protected function equalValues(self $object): bool;

    public static function classEquals(object $object_a, object $object_b): bool
    {
        return get_class($object_a) === get_class($object_b);
    }

    public static function getClassAsString(object $object): string
    {
        return get_class($object);
    }
}