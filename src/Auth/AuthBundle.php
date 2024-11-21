<?php
declare(strict_types=1);

namespace DegustaBox\Auth;

use DegustaBox\Auth\DependencyInjection\AuthExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AuthBundle extends Bundle
{
    protected function getContainerExtensionClass(): string
    {
        return AuthExtension::class;
    }
}