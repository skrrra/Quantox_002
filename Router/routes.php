<?php

require "vendor/autoload.php";

// @TODO: Refactor namespace / folder structure 

use Pecee\SimpleRouter\SimpleRouter;
use App\Api\InternEndpoint;


SimpleRouter::get('/interns', [InternEndpoint::class, 'getAllInterns']);

SimpleRouter::get('/interns/{id}', [InternEndpoint::class, 'getIntern'])->where([ 'id' => '[0-9]+' ]);

SimpleRouter::post('/test', [InternEndpoint::class, 'storeIntern']);
