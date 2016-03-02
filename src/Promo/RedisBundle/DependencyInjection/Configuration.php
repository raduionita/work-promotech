<?php

namespace Promo\RedisBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('redis');
        $root
            ->children()
                ->arrayNode('connection')
                    ->addDefaultsIfNotSet()
                    ->append((new ScalarNodeDefinition('host'))->defaultValue('127.0.0.1'))
                    ->append((new ScalarNodeDefinition('port'))->defaultValue(6379))
                    ->append((new ScalarNodeDefinition('auth'))->defaultValue(''))
                ->end();
        return $treeBuilder;
    }
}