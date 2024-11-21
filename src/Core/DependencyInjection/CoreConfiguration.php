<?php
declare(strict_types=1);

namespace DegustaBox\Core\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class CoreConfiguration implements ConfigurationInterface
{
    const ALIAS = 'core';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder(self::ALIAS);
    }
}