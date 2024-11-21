<?php
declare(strict_types=1);

namespace DegustaBox\Core\Infrastructure\Repository\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use DegustaBox\Core\Domain\ValueObject\Name;
use DegustaBox\Core\Domain\ValueObject\StringValueObject;

class NameType extends JsonType
{
    public function getName(): string
    {
        return 'Name';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Name
    {
        if (null === $value) {
            return null;
        }

        $decode = json_decode($value, true);

        return Name::create(
            StringValueObject::create($decode['firstName']),
            $decode['middleName'] ? StringValueObject::create($decode['middleName']) : null,
            $decode['lastName'] ? StringValueObject::create($decode['lastName']) : null
        );
    }

    /**
     * @param Name|null $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): bool|string|null
    {
        if (null === $value) {
            return null;
        }

        return json_encode([
            'firstName' => $value->firstName->value,
            'middleName' => $value->middleName->value,
            'lastName' => $value->lastName->value,
        ]);
    }
}