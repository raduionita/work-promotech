<?php
/**
 * Created by PhpStorm.
 * Promotion: radu.ionita
 * Date: 04-Mar-16
 * Time: 17:00
 */

namespace Promo\AngularBundle\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PromotionsController extends AbstractController
{
    public function findPromotionsAction()
    {
        return new JsonResponse(['data' => [
            [
                'id'     => 1
                'label'  => 'discount'
                'name'   => 'Discount Promotion',
                'status' => 'offline',
            ],
            [
                'id'     => 2
                'label'  => 'gift'
                'name'   => 'Gift Promotion',
                'status' => 'pending',
            ],
            [
                'id'     => 2
                'label'  => 'bundle'
                'name'   => 'Bundle Promotion',
                'status' => 'online',
            ],
        ]]);
    }

    /**
     * @param  int $id
     * @return JsonResponse
     */
    public function getPromotionAction($id = 0)
    {
        try {
            if (!$id) {
                throw new \Exception("Promotion not found!");
            }
            $data = ['data' => [], 'message' => 'Ok!', 'status' => 'success'];
        } catch (\Exception $e) {
            $status = Response::HTTP_NOT_FOUND;
            $data = ['message' => $e->getMessage(), 'status' => 'failed'];
        }
        
        return new JsonResponse($data, isset($status) ? $status : Response::HTTP_OK);
    }
    
    public function savePromotionAction($id = 0)
    {
        return new JsonResponse([], Response::HTTP_FORBIDDEN);
    }
    
    public function deletePromotionAction($id = 0)
    {
        return new JsonResponse([], Response::HTTP_FORBIDDEN);
    }

    public function getResouceAction($resource = null)
    {
        try {
            if (is_null($resource)) {
                throw new \Exception("Resource not found!");
            }
            $data = ['data' => 'discount', 'message' => 'Found!', 'status' => 'success'];
        } catch (\Exception $e) {
            $status = Response::HTTP_NOT_FOUND;
            $data = ['message' => $e->getMessage(), 'status' => 'failed'];
        }
        return new JsonResponse($data, isset($status) ? $status : Response::HTTP_OK);
    }
}