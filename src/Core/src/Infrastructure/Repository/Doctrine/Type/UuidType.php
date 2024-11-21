<?php
declare(strict_types=1);

namespace DegustaBox\Core\Infrastructure\Repository\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use DegustaBox\Core\Domain\ValueObject\Uuid;

class UuidType extends GuidType
{
    public function getName(): string
    {
        return 'Uuid';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Uuid
    {
        if (null === $value) {
            return null;
        }

        return Uuid::create($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        return $value->value;
    }
}