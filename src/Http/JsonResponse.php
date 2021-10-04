<?php

namespace App\Http;

class JsonResponse
{

    public static function requestFail($http_code)
    {
        static::setHeaderAndResponseCode($http_code);
        return json_encode(['success'   => 'false',
                            'data'      => '{}',
                            'httpCode'  => $http_code,
                            'message'   => HttpResponse::$response[$http_code]]);
    }

    public static function requestSuccess($success, $data, $http_code)
    {
        static::setHeaderAndResponseCode($http_code);
        return json_encode(['success'   => $success,
                            'data'      => $data,
                            'httpCode'  => $http_code,
                            'message'   => HttpResponse::$response[$http_code]]);
    }

    private static function setHeaderAndResponseCode($http_code)
    {
        http_response_code($http_code);
        header('Content-Type: application/json; charset=utf-8');
    }

    public static function routeNotFound()
    {
        static::setHeaderAndResponseCode(404);
        return static::requestFail(HttpResponse::HTTP_NOT_FOUND);
    }

    public static function routeBadRequest()
    {
        static::setHeaderAndResponseCode(400);
        return static::requestFail(HttpResponse::HTTP_BAD_REQUEST);
    }

}