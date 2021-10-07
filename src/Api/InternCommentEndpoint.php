<?php

namespace App\Api;

use App\Models\InternsCommentsModel;
use App\Http\JsonResponse;
use App\Http\HttpResponse;
use App\Interfaces\CrudInterface;
use Pecee\SimpleRouter\SimpleRouter;

class InternCommentEndpoint implements CrudInterface
{
    private $query;

    /**
     * InternCommentEndpoint constructor
     */
    public function __construct()
    {
        $this->query = new InternsCommentsModel();
    }

    /**
     * @return string The returned string contains JSON
     */
    public function get($id) : string
    {
        $queryData = $this->query->getInternComments($id);

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

        if (!isset($queryParams['intern_id'], $queryParams['mentor_id'], $queryParams['comment'])) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST, false);
        }

        $queryResponse = $this->query->createInternComment($queryParams);

        if ($queryResponse == false) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_FORBIDDEN, false);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true, $queryResponse);
    }

    /**
     * @return string The returned string contains JSON
     */
    public function update($id) : string
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalPost();

        if (!is_numeric($id) || empty($queryParams)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST, false);
        }

        $queryResponse = $this->query->updateInternComment($queryParams, $id);

        if (empty($queryResponse)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST, false);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true, $queryParams);
    }

    /**
     * @return string The returned string contains JSON
     */
    public function delete($id) : string
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST, false);
        }

        $queryData = $this->query->deleteInternComment($id);

        if (empty($queryData)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_NOT_FOUND, false);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true);
    }
}