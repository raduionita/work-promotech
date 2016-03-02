<?php

namespace Promo\RedisBundle\Service;

/**
 * Class RedisService wrapper for Redis client
 * @package Promo\RedisBundle\Service
 */
class RedisService
{
    const ID = 'redis'; 
    
    /**
     * @var \Redis
     */
    protected $redis;

    /**
     * @param  array $connection
     * @throws \RedisException
     */
    public function __construct(array $connection)
    {
        $this->redis = new \Redis();
        $this->redis->connect($connection['host'], $connection['port']);
        $this->redis->auth($connection['auth']);
    }

    /**
     * Pass every method call to Redis client
     * @param  string $method
     * @param  array $args
     * @return mixed
     * @throws \RedisException
     */
    public function __call($method, array $args = array())
    {
        if (!isset($this->redis)) {
            throw new \RedisException('Redis client is not instantiated!');
        }
        return \call_user_func_array([$this->redis, $method], $args);
    }
}