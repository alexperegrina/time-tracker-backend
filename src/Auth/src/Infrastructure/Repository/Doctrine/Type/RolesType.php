<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Infrastructure\Repository\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use DegustaBox\Auth\Domain\ValueObject\Enum\Role;

class RolesType extends JsonType
{
    public function getName(): string
    {
        return 'Roles';
    }

    /**
     * @param Role[] $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): bool|string|null
    {
        if ($value === null) {
            return null;
        }

        $data = [];
        foreach ($value as $role) {
            $data[] = $role->value;
        }

        return json_encode($data);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?array
    {
        if (null === $value) {
            return null;
        }

        $decode = json_decode($value, true);

        $data = [];
        foreach ($decode as $role) {
            $data[] = Role::from($role);
        }

        return $data;
    }
}