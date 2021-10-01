<?php

namespace App\Http;

class HttpResponse
{
    CONST HTTP_OK = 200;
    CONST HTTP_BAD_REQUEST = 400;
    CONST HTTP_FORBIDDEN = 403;
    CONST HTTP_NOT_FOUND = 404;

    public static $response = [
        200 => 'Success',
        400 => 'Bad request',
        403 => 'Forbidden',
        404 => 'Not found'
    ];
}