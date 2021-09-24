<?php

namespace App\Http;

class HttpResponse
{
    CONST HTTP_OK = 200;
    CONST HTTP_CREATED = 204;
    CONST HTTP_BAD_REQUEST = 400;
    CONST HTTP_NOT_FOUND = 404;

    public static $response = [
        200 => 'Success',
        204 => 'Created',
        400 => 'Bad request',
        404 => 'Not found'
    ];
}