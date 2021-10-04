<?php

namespace App\Api;

use App\Database\DatabaseQueries;
use App\Http\JsonResponse;
use App\Http\HttpResponse;
use Pecee\SimpleRouter\SimpleRouter;

class InternEndpoint
{
    private $query;

    public function __construct()
    {
        $this->query = new DatabaseQueries();
    }

    public function getAllInterns()
    {
        $queryData = $this->query->getAllInterns();

        if (empty($queryData)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $queryData, HttpResponse::HTTP_OK);
    }

    public function getIntern($id)
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->getIntern($id);

        if (empty($queryData)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $queryData, HttpResponse::HTTP_OK);
    }

    public function createIntern()
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalPost();

        if (!isset($queryParams['full_name'], $queryParams['city'], $queryParams['group_id']) || !is_numeric($queryParams['group_id'])) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->createIntern($queryParams);
        if ($queryData == false) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, $queryData, HttpResponse::HTTP_OK);
    }

    public function updateIntern($id)
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalParams();

        if (!is_numeric($id) || empty($queryParams)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->updateIntern($id, $queryParams);

        if ($queryData) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, $queryParams, HttpResponse::HTTP_OK);
    }

    public function deleteIntern($id)
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->deleteIntern($id);

        if ($queryData == false) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, '{}', HttpResponse::HTTP_OK);
    }
}