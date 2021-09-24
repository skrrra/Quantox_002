<?php

require "vendor/pecee/simple-router/helpers.php";
require "vendor/autoload.php";

use Pecee\SimpleRouter\SimpleRouter as Router;
use App\Http\JsonResponse;
use App\Api\InternEndpoint;



Router::get('/interns', [InternEndpoint::class, 'getAllInterns']);

Router::get('/intern/{id}', [InternEndpoint::class, 'getIntern']);

Router::post('/intern/create', [InternEndpoint::class, 'createIntern']);

Router::patch('/intern/update/{id}', [InternEndpoint::class, 'updateIntern']);

Router::delete('/intern/delete/{id}', [InternEndpoint::class, 'deleteIntern']);

// Route not found 
Router::get('/not-found', [JsonResponse::class, 'routeNotFound']);

// Method not allowed
Router::get('/method-not-allowed', [JsonResponse::class, 'routeBadRequest']);

Router::error(function(\Pecee\Http\Request $request, \Exception $exception) {
    var_dump($exception);
    if($exception->getCode() === 404) {
        response()->redirect('/not-found');
    }
    if($exception->getCode() === 403) {
        response()->redirect('/method-not-allowed');
    }
});

