<?php

require "vendor/autoload.php";

// @TODO: Refactor namespace / folder structure 

use Pecee\SimpleRouter\SimpleRouter;
use Classes\InternEndpoint;


SimpleRouter::get('/test', function() {
    return 'Hello world';
});