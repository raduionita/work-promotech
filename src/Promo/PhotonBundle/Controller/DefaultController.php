<?php

namespace Promo\PhotonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PromoPhotonBundle:Default:index.html.twig');
    }
}
