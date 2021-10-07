<?php

namespace App\Api;

use App\Models\MentorsModel;
use App\Http\JsonResponse;
use App\Http\HttpResponse;
use App\Interfaces\CrudInterface;
use Pecee\SimpleRouter\SimpleRouter;

class MentorEndpoint implements CrudInterface
{

    private $query;

    /**
     * MentorEndpoint constructor
     */
    public function __construct()
    {
        $this->query = new MentorsModel();
    }

    /**
     * @return string The returned string contains JSON
     */
    public function listing() : string
    {
        $queryData = $this->query->getMentorList();

        if (empty($queryData)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_NOT_FOUND, false);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true, $queryData);
    }

    /**
     * @return string The returned string contains JSON
     */
    public function get(int $id) : string
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST, false);
        }

        $queryData = $this->query->getMentor($id);

        if (empty($queryData)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_NOT_FOUND, false);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true, $queryData);
    }

    /**
     * @return string The returned string contains JSON
     */
    public function create() : string
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalPost();

        if (!isset($queryParams['full_name'], $queryParams['group_id']) || !is_numeric($queryParams['group_id'])) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST, false);
        }

        $queryData = $this->query->createMentor($queryParams['full_name'], $queryParams['group_id']);
        if ($queryData == false) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST, false);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true, $queryData);
    }

    /**
     * @return string The returned string contains JSON
     */
    public function update(int $id) : string
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalPost();

        if (!is_numeric($id) || empty($queryParams)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST, false);
        }

        $this->query->updateMentor($queryParams, $id);

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true, $queryParams);
    }

    /**
     * @return string The returned string contains JSON
     */
    public function delete(int $id) : string
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST, false);
        }

        $queryData = $this->query->deleteMentor($id);

        if (empty($queryData)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_NOT_FOUND, false);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true);
    }
}