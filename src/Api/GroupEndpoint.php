<?php

namespace App\Api;

use App\Database\DatabaseQueries;
use App\Http\JsonResponse;
use App\Http\HttpResponse;
use Exception;
use Pecee\SimpleRouter\SimpleRouter;

class GroupEndpoint
{
    private $query;

    public function __construct()
    {
        $this->query = new DatabaseQueries();
    }

    public function getGroupList()
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalParams();

        if (isset($queryParams['per_page']) && !isset($queryParams['page'])) {
            $queryParams['page'] = 1;
        }

        if (!isset($queryParams['per_page'])) {
            $queryParams = [];
        }

        $queryData = $this->query->getGroupList($queryParams);

        if (empty($queryData)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }
        return JsonResponse::requestSuccess(true, $queryData, HttpResponse::HTTP_OK);
    }

    public function getGroup($id)
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->getGroup($id);

        if (empty($queryData)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $queryData, HttpResponse::HTTP_OK);
    }

    public function createGroup()
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalPost();

        if (!isset($queryParams['name'])) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->createGroup($queryParams['name']);
        if (!$queryData) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, $queryData, HttpResponse::HTTP_OK);
    }

    public function updateGroup($id)
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalParams();

        if (!is_numeric($id) || !isset($queryParams['name'])) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->updateGroup($id, $queryParams);

        if ($queryData) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, ['updated_values' => $queryParams], HttpResponse::HTTP_OK);
    }

    public function deleteGroup($id)
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->deleteGroup($id);

        if ($queryData == false) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, '{}', HttpResponse::HTTP_OK);
    }
}