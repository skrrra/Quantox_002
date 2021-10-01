<?php

namespace App\Api;

use App\Database\DatabaseQueries;
use App\Http\JsonResponse;
use App\Http\HttpResponse;
use Pecee\SimpleRouter\SimpleRouter;

class InternCommentEndpoint
{
    private $query;

    public function __construct()
    {
        $this->query = new DatabaseQueries();
    }

    public function getInternComments($id)
    {
        try {
            $queryData = $this->query->getInternComments($id);
        } catch (PDOException $e) {
            return $e->getCode();
        }

        if (empty($queryData)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }
        return JsonResponse::requestSuccess(true, $queryData, HttpResponse::HTTP_OK);
    }

    public function createInternComment()
    {
        $params = SimpleRouter::request()->getInputHandler()->getOriginalPost();

        if(!isset($params['intern_id'], $params['mentor_id'], $params['comment'])){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        try {
            $queryResponse = $this->query->createInternComment($params);
        } catch (PDOException $e) {
            return $e->getCode();
        }

        if($queryResponse == false){
            return JsonResponse::requestFail(HttpResponse::HTTP_FORBIDDEN);
        }else{
            return JsonResponse::requestSuccess(true, $queryResponse, HttpResponse::HTTP_OK);
        }
    }

    public function updateInternComment($id)
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->all();

        if (!is_numeric($id)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        if (empty($queryParams)){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryResponse = $this->query->updateInternComment($queryParams, $id);
            
        if ($queryResponse) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, $queryParams, HttpResponse::HTTP_OK);
    }

    public function deleteInternComment($id)
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        try {
            $queryResponse = $this->query->deleteInternComment($id);
        } catch (\Exception $e) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        if ($queryResponse == false) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, '{}', HttpResponse::HTTP_OK);
    }
}