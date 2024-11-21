<?php
declare(strict_types=1);

namespace DegustaBox\Core\Domain\ValueObject\Enum;

enum Gender
{
    case male;
    case female;
    case unknown;

    public static function fromName(string $name): self
    {
        return constant("self::$name");
    }
}