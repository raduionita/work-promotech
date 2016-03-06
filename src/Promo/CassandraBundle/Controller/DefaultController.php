<?php

namespace Promo\CassandraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        try {
            $builder = \Cassandra::cluster();                             // cluster(client) builder
            $cluster = $builder->build();                                 // connect to localhost by default
            $session = $cluster->connect('promotech');                    // create session, optionaly w/ scoped keyspace
            $stmt = new \Cassandra\SimpleStatement('SELECT * FROM user'); // statement, supports prepared batch statements
            $future = $session->executeAsync($stmt);                      // async execution
            $result = $future->get();                                     // wait for result, w/ optional timeout

            foreach ($result as $row) {
                print_r($row);
            }
        } catch (\Cassandra\Exception $e) {

        }
        
        return $this->render('PromoCassandraBundle:Default:index.html.twig');
    }
}
