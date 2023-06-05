<?php
namespace App\Core;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AppKernel
{
    private ContainerInterface $container;
    private $dispatcher;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->initRoutes();
    }

    private function initRoutes(): void
    {
        $this->dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $r) {
            // Include the route definitions for each module
            $modules = [
                __DIR__ . '/../../routes/routes.php',
                // Add more modules here...
            ];

            foreach ($modules as $moduleRoutes) {
                $routesCallback = require $moduleRoutes;
                $routesCallback($r, $this->container);
            }
        });
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function dispatch(RequestInterface $request): Response
    {
        // Dispatch the route
        $routeInfo = $this->dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

        // Process the route result
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // Handle 404 Not Found
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                // Handle 405 Method Not Allowed
                break;
            case Dispatcher::FOUND:
                session_start();
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                // Call the handler method
                [$controllerClass, $method] = $handler;

                // Resolve dependencies using the DI container
                $controller = $this->container->get($controllerClass);
                $response = $this->container->get(ResponseInterface::class);

                // Call the handler method with the resolved dependencies
                return $controller->$method($request, $response, $vars);
        }

        return new Response(500, [], 'Unknown Error');
    }
}