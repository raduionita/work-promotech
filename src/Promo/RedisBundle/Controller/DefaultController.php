<?php

namespace Promo\RedisBundle\Controller;

use Promo\RedisBundle\Service\RedisService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @param  Request $request
     * @return Response
     */
    public function indexAction(Request $request) : Response
    {
        // replace this example code with whatever you need 
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
    
    public function testAction(Request $response) : Response
    {
        try {
            /** @var \Redis $redis */
            $redis = $this->container->get(RedisService::ID);
            
            $redis->select(1);
            echo 'Server is runnung '. $redis->ping() ."\n";

            $redis->set('keyA', 10);
            $redis->setex('keyB', 120, 'something');
            //$redis->lPush('listA', 'World');
            //$redis->lPush('listA', 'Hello');
            $item = $redis->rPop('listA');
            //$redis->rPush('listA', 'PHP');

            $value  = $redis->get('keyA');
            $values = $redis->mget(['keyA', 'keyB', 'keyC']);
            $list = $redis->lRange('listA', 0, 10);

            //$redis->del('keyC');
            if ($redis->exists('keyC')) {
                echo 'keyC found!', "\n";
            }

            $redis->set('keyC', 'big balue');
            $redis->persist('keyC');

            //$redis->subscribe(['channel0', 'channel1'], function($redis, $channel, $message) {
            //    
            //});

            echo 'info:', print_r($redis->info()), "\n";
            
            echo 'Published to ', $redis->publish('channel0', 'DefaultController::redisAction() > Hello world!'), ' clients', "\n";

            //$redis->flushAll(); // clears all dbs
            //$redis->flushDB();  // clears this db

            echo 'keyA          :', print_r($value, 1), ' ttl: ', $redis->ttl('keyA'), "\n";
            echo 'keyA,keyB,keyC:', print_r($values, 1), "\n";
            echo 'keyC          :', $redis->get('keyC'), ' ttl: ',  $redis->ttl('keyC'), "\n";
            echo 'listA         :', print_r($list, 1),   "\n";
            echo 'dbSize        :', $redis->dbSize(),   "\n"; // in keys
            echo 'all keys      :', print_r($redis->keys('*')),   "\n";
        } catch (\RedisException $e) {
            die('Exception: '. $e->getMessage());
        }
        
        echo 'CPU:', print_r(sys_getloadavg(), 1), "\n"; // cpu load last 1, 5 & 15 mins
        echo 'MEM:', memory_get_peak_usage(true) / (1024*1024), 'M', "\n";
        return new Response('redis');
    }
}
