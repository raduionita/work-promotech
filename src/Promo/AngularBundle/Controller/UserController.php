<?php
/**
 * Created by PhpStorm.
 * User: radu.ionita
 * Date: 04-Mar-16
 * Time: 17:00
 */

namespace Promo\AngularBundle\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    public function findAction()
    {
        return new JsonResponse(['data' => [
            [
                'name' => 'Adrian Tilita',
                'status' => true,
            ],
            [
                'name' => 'Bogdan Tudor',
                'status' => true,
            ],
        ]]);
    }

    /**
     * @param  int $id
     * @return JsonResponse
     */
    public function getAction($id = 0)
    {
        try {
            $data = ['data' => [], 'message' => 'Ok!', 'status' => 'success'];
        } catch (\Exception $e) {
            $status = Response::HTTP_NOT_FOUND;
            $data = ['message' => 'User not found!', 'status' => 'failed'];
        }
        
        return new JsonResponse($data, isset($status) ? $status : Response::HTTP_OK);
    }
    
    public function saveAction($id = 0)
    {
        return new JsonResponse([], Response::HTTP_FORBIDDEN);
    }
    
    public function delete($id = 0)
    {
        return new JsonResponse([], Response::HTTP_FORBIDDEN);
    }
}