<?php

require "vendor/autoload.php";

    Router::get('/intern/{id}', [InternEndpoint::class, 'getIntern']);

    Router::post('/intern/create', [InternEndpoint::class, 'createIntern']);

    Router::patch('/intern/update/{id}', [InternEndpoint::class, 'updateIntern']);

    Router::delete('/intern/delete/{id}', [InternEndpoint::class, 'deleteIntern']);
});

//
// Mentors Api endpoint routes
//
Router::group(['namespace' => 'MentorEndpoint'], function() {
    Router::get('/mentors', [MentorEndpoint::class, 'getMentorList']);

    Router::get('/mentor/{id}', [MentorEndpoint::class, 'getMentor']);

    Router::post('/mentor/create', [MentorEndpoint::class, 'createMentor']);

    Router::patch('/mentor/update/{id}', [MentorEndpoint::class, 'updateMentor']);

    Router::delete('/mentor/delete/{id}', [MentorEndpoint::class, 'deleteMentor']);
});

//
// Groups Api endpoint routes
//
Router::group(['namespace' => 'GroupEndpoint'], function(){
    Router::get('/groups', [GroupEndpoint::class, 'getGroupList']);

    Router::get('/group/{id}', [GroupEndpoint::class, 'getGroup']);

    Router::post('/group/create', [GroupEndpoint::class, 'createGroup']);

    Router::patch('/group/update/{id}', [GroupEndpoint::class, 'updateGroup']);

    Router::delete('/group/delete/{id}', [GroupEndpoint::class, 'deleteGroup']);
});


Router::group(['namespace' => 'InternComments'], function(){
    Router::get('/intern-comment/{id}', [InternCommentEndpoint::class, 'getInternComments']);

    Router::post('/intern-comment/create', [InternCommentEndpoint::class, 'createInternComment']);

    Router::patch('/intern-comment/update/{id}', [InternCommentEndpoint::class, 'updateInternComment']);

    Router::delete('/intern-comment/delete/{id}', [InternCommentEndpoint::class, 'deleteInternComment']);
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

SimpleRouter::get('/test', function() {
    return 'Hello world';
});
