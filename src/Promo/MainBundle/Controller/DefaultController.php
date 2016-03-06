<?php

namespace Promo\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PromoMainBundle:Default:index.html.twig');
    }
}
