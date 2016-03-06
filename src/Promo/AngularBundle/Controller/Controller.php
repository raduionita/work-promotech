<?php

namespace Promo\AngularBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

abstract class AbstractController implements ContainerAwareInterface
{
    use ContainerAwareTrait;
}