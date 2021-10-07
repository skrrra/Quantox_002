<?php

require "vendor/pecee/simple-router/helpers.php";

use Pecee\SimpleRouter\SimpleRouter as Router;
use App\Http\JsonResponse;
use App\Api\InternEndpoint;
use App\Api\MentorEndpoint;
use App\Api\GroupEndpoint;
use App\Api\InternCommentEndpoint;

//
//Interns Api endpoint routes
//
Router::group(['namespace' => 'InternEndpoint'], function () {
    Router::get('/interns', [InternEndpoint::class, 'listing']);

    Router::get('/intern/{id}', [InternEndpoint::class, 'get']);

    Router::post('/intern/create', [InternEndpoint::class, 'create']);

    Router::patch('/intern/update/{id}', [InternEndpoint::class, 'update']);

    Router::delete('/intern/delete/{id}', [InternEndpoint::class, 'delete']);
});

//
// Mentors Api endpoint routes
//
Router::group(['namespace' => 'MentorEndpoint'], function() {
    Router::get('/mentors', [MentorEndpoint::class, 'listing']);

    Router::get('/mentor/{id}', [MentorEndpoint::class, 'get']);

    Router::post('/mentor/create', [MentorEndpoint::class, 'create']);

    Router::patch('/mentor/update/{id}', [MentorEndpoint::class, 'update']);

    Router::delete('/mentor/delete/{id}', [MentorEndpoint::class, 'delete']);
});

//
// Groups Api endpoint routes
//
Router::group(['namespace' => 'GroupEndpoint'], function(){
    Router::get('/groups', [GroupEndpoint::class, 'listing']);

    Router::get('/group/{id}', [GroupEndpoint::class, 'get']);

    Router::post('/group/create', [GroupEndpoint::class, 'create']);

    Router::patch('/group/update/{id}', [GroupEndpoint::class, 'update']);

    Router::delete('/group/delete/{id}', [GroupEndpoint::class, 'delete']);
});

//
// Intern Comments Api endpoint routes
//
Router::group(['namespace' => 'InternComments'], function(){
    Router::get('/intern-comment/{id}', [InternCommentEndpoint::class, 'get']);

    Router::post('/intern-comment/create', [InternCommentEndpoint::class, 'create']);

    Router::patch('/intern-comment/update/{id}', [InternCommentEndpoint::class, 'update']);

    Router::delete('/intern-comment/delete/{id}', [InternCommentEndpoint::class, 'delete']);
});

//
// Route error handling
//

// Route not found
Router::get('/not-found', [JsonResponse::class, 'routeNotFound']);

// Method not allowed
Router::get('/method-not-allowed', [JsonResponse::class, 'routeBadRequest']);

// Redirect setup based on http response
Router::error(function(\Pecee\Http\Request $request, \Exception $exception) {
    if($exception->getCode() === 404) {
        response()->redirect('/not-found');
    }
    if($exception->getCode() === 403) {
        response()->redirect('/method-not-allowed');
    }
});
