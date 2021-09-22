<?php

namespace App\Http;

use App\Http\HttpResponse;

class JsonResponse
{   
    
    public static function requestFail($success, $data, $http_code)
    {
        static::setHeaderAndResponseCode($http_code);
        return json_encode(['success'   => $success,
                            'data'      => $data,
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

}