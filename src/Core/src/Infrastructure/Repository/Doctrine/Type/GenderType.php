<?php
declare(strict_types=1);

namespace DegustaBox\Core\Infrastructure\Repository\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use DegustaBox\Core\Domain\ValueObject\Enum\Gender;

class GenderType extends Type
{
    public function getName(): string
    {
        return 'Gender';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $values = array_map(fn ($item) => "'$item'", array_column(Gender::cases(), 'name'));
        return sprintf('ENUM(%s)', implode(', ', $values));
    }

    /**
     * @param Gender|null $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->name;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Gender
    {
        if (null === $value) {
            return null;
        }

        return Gender::fromName($value);
    }
}