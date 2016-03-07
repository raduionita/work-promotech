<?php

namespace Promo\AngularBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function indexAction()
    {
        return (new Response())->setContent($this->container->get('twig')->render('PromoAngularBundle:Default:index.html.twig', []));
    }
}
