<?php

namespace Promo\MemcacheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('PromoMemcacheBundle:Default:index.html.twig');
    }

    public function testAction(Request $request) : Response
    {
        try {
            $memcache = new \Memcached('promo.ui.emag.local'); // memcache client
            $memcache->addServer('127.0.0.1', 11211);

            $memcache->set('keyA', 'I just stored this!', 120);
            echo $value = $memcache->get('keyA'), "\n";
            $memcache->delete('keyA');
        } catch (\MemcachedException $e) {
            die($e->getMessage());
        }
        return new Response('memcache');
    }
}
