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
        $queryData = $this->query->getInternComments($id);

        if (empty($queryData)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $queryData, HttpResponse::HTTP_OK);
    }

    public function createInternComment()
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalPost();

        if (!isset($queryParams['intern_id'], $queryParams['mentor_id'], $queryParams['comment'])) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryResponse = $this->query->createInternComment($queryParams);

        if ($queryResponse == false) {
            return JsonResponse::requestFail(HttpResponse::HTTP_FORBIDDEN);
        }

        return JsonResponse::requestSuccess(true, $queryResponse, HttpResponse::HTTP_OK);
    }

    public function updateInternComment($id)
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalParams();

        if (!is_numeric($id) || empty($queryParams)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryResponse = $this->query->updateInternComment($queryParams, $id);

        if ($queryResponse == false) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, $queryParams, HttpResponse::HTTP_OK);
    }

    public function deleteInternComment($id)
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryResponse = $this->query->deleteInternComment($id);

        if ($queryResponse == false) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, '{}', HttpResponse::HTTP_OK);
    }
}