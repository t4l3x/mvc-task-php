<?php

use App\Core\AppKernel;

use Nyholm\Psr7\Factory\Psr17Factory;
use Dotenv\Dotenv;
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$container = require __DIR__ . '/../config/dependencies.php';
$appRouter = new AppKernel($container);



// Create a ServerRequest instance
$requestFactory = new Psr17Factory();
$request = $requestFactory->createServerRequest($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

// Use $_POST superglobal if the request method is POST and the form data is of type application/x-www-form-urlencoded or multipart/form-data
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    (stripos($_SERVER['CONTENT_TYPE'], 'application/x-www-form-urlencoded') === 0 ||
        stripos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') === 0)) {
    // Sanitize $_POST data here if necessary
    $request = $request->withParsedBody($_POST);
}

try {
    $response = $appRouter->dispatch($request);
} catch (\Psr\Container\NotFoundExceptionInterface|\Psr\Container\ContainerExceptionInterface $e) {
    // Handle exceptions here
}

// Send the response
header('HTTP/1.1 ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}
echo $response->getBody();