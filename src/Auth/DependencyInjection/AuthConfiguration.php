<?php
declare(strict_types=1);

namespace DegustaBox\Auth\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class AuthConfiguration implements ConfigurationInterface
{
    const ALIAS = 'auth';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder(self::ALIAS);
    }
}