<?php

namespace App\Api;

use App\Database\DatabaseQueries;
use App\Http\JsonResponse;
use App\Http\HttpResponse;
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
        $params = SimpleRouter::request()->getInputHandler()->getOriginalParams();

        if (isset($params['per_page']) && !isset($params['page'])) {
            $params['page'] = 1;
        }

        try {
            if (!isset($params['per_page'])) {
                $params = [];
            }
            $queryData = $this->query->getGroupList($params);
        } catch (PDOException $e) {
            return $e->getCode();
        }

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

        try {
            $queryData = $this->query->getGroup($id);
        } catch (PDOException $e) {
            throw $e->getCode();
        }

        if (empty($queryData)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $queryData, HttpResponse::HTTP_OK);
    }

    public function createGroup()
    {
        $params = SimpleRouter::request()->getInputHandler()->getOriginalPost();
        
        if (!isset($params['name'])) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }
    
        try {
            $queryData = $this->query->createGroup($params['name']);
            if (!$queryData) {
                return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, $queryData, HttpResponse::HTTP_OK);
    }

    public function updateGroup($id)
    {
        $params = SimpleRouter::request()->getInputHandler()->getOriginalPost();

        if (!is_numeric($id) || !isset($params['name'])) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->updateGroup($id, $params);

        if ($queryData) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, ['updated_values' => $params], HttpResponse::HTTP_OK);
    }

    public function deleteGroup($id)
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        try {
            $queryData = $this->query->deleteGroup($id);
        } catch (\Exception $e) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        if ($queryData == false) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, '{}', HttpResponse::HTTP_OK);
    }
}