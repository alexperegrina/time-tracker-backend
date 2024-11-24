<?php
declare(strict_types=1);

namespace DegustaBox\Core\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class CoreConfiguration implements ConfigurationInterface
{
    const ALIAS = 'core';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::ALIAS);
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->append($this->nodeValidator())
            ->end();

        return $treeBuilder;
    }

    protected function nodeValidator(): ArrayNodeDefinition|NodeDefinition
    {
        $treeBuilder = new TreeBuilder('validator');
        $node = $treeBuilder->getRootNode();
        $node
            ->children()
                ->arrayNode('schema')
                ->children()
                    ->arrayNode('declare')
                        ->arrayPrototype()
                            ->children()
                                ->scalarNode('path')->isRequired()->end()
                                ?->scalarNode('prefix')->isRequired()->end()
                            ?->end()
                        ->end()
                    ->end()
                ->end()
                ->end()
            ->end();

        return $node;
    }
}