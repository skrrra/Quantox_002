<?php

require "vendor/pecee/simple-router/helpers.php";
require "vendor/autoload.php";

use Pecee\SimpleRouter\SimpleRouter as Router;
use App\Http\JsonResponse;
use App\Api\InternEndpoint;
use App\Api\MentorEndpoint;
use App\Api\GroupEndpoint;

//
//Interns Api endpoint routes
//
Router::group(['namespace' => 'InternEndpoint'], function () {
    Router::get('/interns', [InternEndpoint::class, 'getAllInterns']);

    Router::get('/intern/{id}', [InternEndpoint::class, 'getIntern']);

    Router::post('/intern/create', [InternEndpoint::class, 'createIntern']);

    Router::patch('/intern/update/{id}', [InternEndpoint::class, 'updateIntern']);

    Router::delete('/intern/delete/{id}', [InternEndpoint::class, 'deleteIntern']);
});

Router::group(['namespace' => 'MentorEndpoint'], function() {
    Router::get('/mentors', [MentorEndpoint::class, 'getMentorList']);

    Router::get('/mentor/{id}', [MentorEndpoint::class, 'getMentor']);

    Router::post('/mentor/create', [MentorEndpoint::class, 'createMentor']);

    Router::patch('/mentor/update/{id}', [MentorEndpoint::class, 'updateMentor']);

    Router::delete('/mentor/delete/{id}', [MentorEndpoint::class, 'deleteMentor']);
});

Router::group(['namespace' => 'GroupEndpoint'], function(){
    Router::get('/groups', [GroupEndpoint::class, 'getGroupList']);

    Router::get('/group/{id}', [GroupEndpoint::class, 'getGroup']);

    Router::post('/group/create', [GroupEndpoint::class, 'createGroup']);

    Router::patch('/group/update/{id}', [GroupEndpoint::class, 'updateGroup']);

    Router::delete('/group/delete/{id}', [GroupEndpoint::class, 'deleteGroup']);
});


//
// Route error handling
//

// Route not found 
Router::get('/not-found', [JsonResponse::class, 'routeNotFound']);

// Method not allowed
Router::get('/method-not-allowed', [JsonResponse::class, 'routeBadRequest']);

Router::error(function(\Pecee\Http\Request $request, \Exception $exception) {
    if($exception->getCode() === 404) {
        response()->redirect('/not-found');
    }
    if($exception->getCode() === 403) {
        response()->redirect('/method-not-allowed');
    }
});

