<?php

namespace Promo\MemcacheBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    { 
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('promo_memcache');
        $root->children()
            ->arrayNode('connections')
                ->useAttributeAsKey('name')
                ->prototype('array')
                ->children()
                    ->scalarNode('host')->end()
                    ->scalarNode('port')->end()
                    ->scalarNode('weight')->defaultValue(0)->end()
                ->end()
            ->end();
        return $treeBuilder;
    }
}
