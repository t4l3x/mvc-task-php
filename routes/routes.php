<?php

use App\Middleware\TokenAuthenticationMiddleware;
use FastRoute\RouteCollector;


return function (RouteCollector $routeCollector) {

    $routeCollector->addGroup('/post', function (RouteCollector $routeCollector) {
        $articleController = 'App\Controller\PostsController';
        // Apply middleware to the desired routes
        $routeCollector->get('', [$articleController, 'home']);
        // Other routes without middleware
        $routeCollector->post('', [$articleController, 'create']);
    });
};