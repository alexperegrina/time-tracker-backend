<?php
declare(strict_types=1);

namespace DegustaBox\Auth\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AuthExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $this->loadFromEnvironment($loader, $container->getParameter('kernel.environment'));
    }

    public function getAlias(): string
    {
        return AuthConfiguration::ALIAS;
    }

    public function getConfiguration(array $config, ContainerBuilder $container): AuthConfiguration
    {
        return new AuthConfiguration();
    }

    protected function loadFromEnvironment(YamlFileLoader $loader,  string $environment, string $nameFile = 'services'): void
    {
        $loader->load("$nameFile.yaml");
        try {
            $loader->load("{$nameFile}.$environment.yaml");
        } catch (Exception) {}
    }
}