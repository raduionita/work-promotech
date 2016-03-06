<?php

namespace Promo\CassandraBundle\Service;

use Promo\CassandraBundle\Repository\EntityRepository;

class CassandraService
{
    protected $sessions     = [];
    protected $repositories = [];
    
    public function __construct()
    {
        $builder = \Cassandra::cluster();                             // cluster(client) builder
        $cluster = $builder->build();                                 // connect to localhost by default
        $session = $cluster->connect('promotech');                    // create session, optionaly w/ scoped keyspace
    }

    /**
     * @param  string $repository
     * @param  string $connection
     * @return EntityRepository
     */
    public function getRepository($repository, $connection = 'default') : EntityRepository
    {
        if (!is_string($repository) || !is_string($connection)) {
            throw new \Cassandra\Exception\ConfigurationException("That is not a string");
        }
        
        if (!isset($this->sessions[$connection])) {
            // enable connection
            $builder = \Cassandra::cluster();

            // get config for 'default' connection
            $config['keyspace'] = 'promotech';
            
            $cluster = $builder->build();
            //$builder->withPort($config['port']);

            $session = $cluster->connect($config['keyspace']);
            $this->sessions[$connection] = $session;
        }
        
        list($bundle, $entity) = explode(':', $repository);
        if (!isset($this->repositories[$entity])) {
            $repository = $bundle.'\\'.$entity . 'Repository';
            $this->repositories[$entity] = new $repository($this->sessions[$connection]); 
        }
        
        // find repo class
        
    }
}