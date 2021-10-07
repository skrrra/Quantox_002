<?php

namespace App\Api;

use App\Models\GroupsModel;
use App\Http\JsonResponse;
use App\Http\HttpResponse;
use App\Interfaces\CrudInterface;
use Pecee\SimpleRouter\SimpleRouter;

class GroupEndpoint implements CrudInterface
{
    private $query;

    /**
     * GroupEndpoint constructor
     */
    public function __construct()
    {
        $this->query = new GroupsModel();
    }

    /**
     * @return string The returned string contains JSON
     */
    public function listing() : string
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

        $queryData = $this->query->getGroup($id);

        if (empty($queryData)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_NOT_FOUND, false);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true, $queryData);
    }

    /**
     * @return string The returned string contains JSON
     */
    public function create(): string
    {
        $queryParams = SimpleRouter::request()->getInputHandler()->getOriginalPost();

        if (!isset($queryParams['name'])) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST, false);
        }

        $queryData = $this->query->createGroup($queryParams['name']);
        if (!$queryData) {
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

        if (!is_numeric($id) || !isset($queryParams['name'])) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST, false);
        }

        $queryData = $this->query->updateGroup($id, $queryParams);

        if ($queryData) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST, false);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true, ['updated_values' => $queryParams]);
    }

    /**
     * @return string The returned string contains JSON
     */
    public function delete(int $id) : string
    {
        if (!is_numeric($id)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_BAD_REQUEST, false);
        }

        $queryData = $this->query->deleteGroup($id);

        if (empty($queryData)) {
            return JsonResponse::requestResponse(HttpResponse::HTTP_NOT_FOUND, false);
        }

        return JsonResponse::requestResponse(HttpResponse::HTTP_OK, true);
    }
}