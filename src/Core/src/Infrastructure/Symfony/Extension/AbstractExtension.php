<?php
declare(strict_types=1);

namespace DegustaBox\Core\Infrastructure\Symfony\Extension;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

use Exception;

abstract class AbstractExtension extends Extension
{
    protected function loadFromEnvironment(YamlFileLoader $loader,  string $environment, string $nameFile = 'services'): void
    {
        $loader->load("$nameFile.yaml");
        try {
            $loader->load("{$nameFile}.$environment.yaml");
        } catch (Exception) {}
    }
}