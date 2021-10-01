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
        try {
            $data = $this->query->getAllInterns();
        } catch (PDOException $e) {
            return $e->getCode();
        }

        if (empty($data)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $data, HttpResponse::HTTP_OK);
    }

    public function getIntern($id)
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        try {
            $data = $this->query->getIntern($id);
        } catch (PDOException $e) {
            throw $e->getCode();
        }

        if (empty($data)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $data, HttpResponse::HTTP_OK);
    }

    public function createIntern()
    {
        $params = SimpleRouter::request()->getInputHandler()->all();

        if (!isset($params['full_name'], $params['city'], $params['group_id'])) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }
    
        try {
            $data = $this->query->createIntern($params);
            if (!$data) {
                return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, $data, HttpResponse::HTTP_OK);
    }

    public function updateIntern($id)
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $data = SimpleRouter::request()->getInputHandler()->all();

        $params = $this->query->updateIntern($id, $data);
            
        if ($params) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, [], HttpResponse::HTTP_OK);
    }

    public function deleteIntern($id)
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        try {
            $data = $this->query->deleteIntern($id);
        } catch (\Exception $e) {
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        if ($data == false) {
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, '{}', HttpResponse::HTTP_OK);
    }
}
