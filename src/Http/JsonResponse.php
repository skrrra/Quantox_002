<?php

namespace App\Http;

class JsonResponse
{
    /**
     * @return string The returned string contains JSON
     */
    public static function requestResponse(int $http_code, bool $success = false, array $data = []) : string
    {
        static::setHeaderAndResponseCode($http_code);
        return json_encode(['success'   => $success,
                            'data'      => $data,
                            'httpCode'  => $http_code,
                            'message'   => HttpResponse::$response[$http_code]]);
    }

    private static function setHeaderAndResponseCode(int $http_code) : void
    {
        http_response_code($http_code);
        header('Content-Type: application/json; charset=utf-8');
    }

    /**
     * @return string The returned string contains JSON
     */
    public static function routeNotFound() : string
    {
        static::setHeaderAndResponseCode(404);
        return static::requestResponse(HttpResponse::HTTP_NOT_FOUND);
    }

    /**
     * @return string The returned string contains JSON
     */
    public static function routeBadRequest() : string
    {
        static::setHeaderAndResponseCode(400);
        return static::requestResponse(HttpResponse::HTTP_BAD_REQUEST);
    }

}