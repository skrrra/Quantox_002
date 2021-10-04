<?php

namespace App\Api;

use App\Database\DatabaseQueries;
use App\Http\JsonResponse;
use App\Http\HttpResponse;
use Pecee\SimpleRouter\SimpleRouter;

class MentorEndpoint
{

    private $query;

    public function __construct()
    {
        $this->query = new DatabaseQueries();
    }

    public function getMentorList()
    {
        $queryData = $this->query->getMentorList();

        if (empty($queryData)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $queryData, HttpResponse::HTTP_OK);
    }

    public function getMentor($id)
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->getMentor($id);

        if (empty($queryData)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $queryData, HttpResponse::HTTP_OK);
    }

    public function createMentor()
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalPost();

        if (!isset($queryParams['full_name'], $queryParams['group_id']) || !is_numeric($queryParams['group_id'])) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->createMentor($queryParams['full_name'], $queryParams['group_id']);
        if ($queryData == false) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, $queryData, HttpResponse::HTTP_OK);
    }

    public function updateMentor($id)
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalParams();

        if (!is_numeric($id) || empty($queryParams)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $this->query->updateMentor($queryParams, $id);

        return JsonResponse::requestSuccess(true, $queryParams, HttpResponse::HTTP_OK);
    }

    public function deleteMentor($id)
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->deleteMentor($id);

        if ($queryData == false) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, '{}', HttpResponse::HTTP_OK);
    }
}