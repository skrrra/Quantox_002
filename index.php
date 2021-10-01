<?php

require_once 'Router/routes.php';

use Pecee\SimpleRouter\SimpleRouter;
use App\Database\DatabaseQueries;
use App\Api\InternEndpoint;

/* Load external routes file */
/**
 * The default namespace for route-callbacks, so we don't have to specify it each time.
 * Can be overwritten by using the namespace config option on your routes.
 */

SimpleRouter::setDefaultNamespace('App\Api');

// Start the routing
SimpleRouter::start();

