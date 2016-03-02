<?php

namespace Promo\RedisBundle\DependencyInjection;

use Promo\RedisBundle\Service\RedisService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class PromoRedisExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration(); 
        $config = $this->processConfiguration($configuration, $configs);
        
        $definition = new Definition('Promo\RedisBundle\Service\RedisService', [$config['connection']]);
        $container->setDefinition(RedisService::ID, $definition);

        //$loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        //$loader->load('services.xml');
    }
}