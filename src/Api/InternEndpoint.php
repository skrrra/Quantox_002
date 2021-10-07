<?php

namespace App\Api;

use App\Models\InternsModel;
use App\Http\JsonResponse;
use App\Http\HttpResponse;
use App\Interfaces\CrudInterface;
use Pecee\SimpleRouter\SimpleRouter;

class InternEndpoint implements CrudInterface
{
    private $query;

    /**
     * InternEndpoing constructor
     */
    public function __construct()
    {
        $this->query = new InternsModel();
    }

    /**
     * @return string The returned string contains JSON
     */
    public function listing() : string
    {
        $queryData = $this->query->getAllInterns();

        if (empty($queryData)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true, $queryData);
    }

    /**
     * @return string The returned string contains JSON
     */
    public function get($id): string
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->getIntern($id);

        if (empty($queryData)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true, $queryData);
    }

    /**
     * @return string The returned string contains JSON
     */
    public function create() : string
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalPost();

        if (!isset($queryParams['full_name'], $queryParams['city'], $queryParams['group_id']) || !is_numeric($queryParams['group_id'])) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->createIntern($queryParams);
        if ($queryData == false) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true, $queryData);
    }

    /**
     * @return string The returned string contains JSON
     */
    public function update($id) : string
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalPost();

        if (!is_numeric($id) || empty($queryParams)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->updateIntern($id, $queryParams);

        if (empty($queryData)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true, $queryParams);
    }

    /**
     * @return string The returned string contains JSON
     */
    public function delete($id) : string
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST);
        }

        $queryData = $this->query->deleteIntern($id);

        if (empty($queryData)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true);
    }
}