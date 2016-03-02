<?php

namespace Promo\MemcacheBundle\Service;

class MemcacheService
{
    const ID = 'memcache';
    
    /**
     * @var \Memcached
     */
    public $memcached;
    
    public function __construct(array $connections)
    {
        $this->memcached = new \Memcached();
        foreach ($connections as $name => $connection) {
            $this->memcached->addServer($connection['host'], $connection['port'], $connection['weight']);
        }
    }

    public function __call($method, array $args = array())
    {
        if (!isset($this->memcached)) {
            throw new \MemcachedException('Memcache client is not instantiated!');
        }
        return \call_user_func_array([$this->memcached, $method], $args);
    }
}