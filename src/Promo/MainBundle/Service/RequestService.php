<?php

namespace Promo\MainBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestService
{
    /**
     * @var Request
     */
    private $request;
    
    public function __construct(RequestStack $stack)
    {
        $this->request = $stack->getCurrentRequest();
    }

    public function __call($method, array $args)
    {
        if (!method_exists($this->request, $method)) {
            return $this->request->$method(isset($args[0]) ? $args[0] : null);
        } else {
            return call_user_func_array([$this->request, $method], $args);
        }
    }
    
    public function __get($name)
    {
        return $this->request->$name;
    }
    
    public function __set($name, $value = null)
    {
        $this->request->$name = $value;
    }
}