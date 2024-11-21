<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Domain\ValueObject\Enum;

enum Role: string
{
    case SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    case ADMIN = 'ROLE_ADMIN';
    case USER = 'ROLE_USER';
    case LANDING = 'ROLE_LANDING';
    case MANAGER = 'ROLE_MANAGER';
}