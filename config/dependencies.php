<?php


use App\Core\Database\PdoConnectionFactory;
use App\Core\Database\QueryFactory;
use App\Core\Notifications\EmailNotifier;
use App\Core\Notifications\SmsNotifier;
use App\Core\Services\SomeSmsService;
use App\Core\Services\SwiftMailerService;
use App\Services\NotificationService;
use DI\ContainerBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$builder = new ContainerBuilder();

// If you want to use the compiled container
// $builder->enableCompilation('/path/to/your/cache/directory');

$definitions = [
    PdoConnectionFactory::class => function () {
        return new PdoConnectionFactory('db', 'post', 'root', '');
    },
    QueryFactory::class => function (ContainerInterface $c) {
        $pdoConnectionFactory = $c->get(PdoConnectionFactory::class);
        return new QueryFactory($pdoConnectionFactory);
    },

    ServerRequestInterface::class => function () {
        return (new Psr17Factory())->createServerRequest($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    },
    ResponseInterface::class => function () {
        return new Response();
    },
    Environment::class => function (ContainerInterface $c) {
        $loader = new FilesystemLoader(__DIR__ . '/../src/View/');
        return new Environment($loader, [
            'csrf' => true,
            'debug' => true,
        ]);
    },
    SwiftMailerService::class => function () {
        // Here you would initialize the SwiftMailerService with necessary parameters
        // I am leaving it blank as I do not know the specific implementation details
        return new SwiftMailerService('mailpit', 1025, 'username', 'password');
    },
    SomeSmsService::class => function () {
        // Here you would initialize the SomeSmsService with necessary parameters
        // I am leaving it blank as I do not know the specific implementation details
        return new SomeSmsService();
    },
    EmailNotifier::class => function (ContainerInterface $c) {
        return new EmailNotifier($c->get(SwiftMailerService::class));
    },

    SmsNotifier::class => function (ContainerInterface $c) {
        // You need to provide the corresponding service for SMS
        // As of now, I do not know the specific implementation details
        // Replace 'SomeSmsService' with your actual implementation
        return new SmsNotifier($c->get(SomeSmsService::class));
    },

    'App\Services\NotificationService' => function (ContainerInterface $c) {
        return new NotificationService(
            $c->get(EmailNotifier::class),
            $c->get(SmsNotifier::class)
        );
    },


    // Add more dependencies here...
];

$builder->addDefinitions($definitions);
try {
    $container = $builder->build();
    return $container;
} catch (Exception $e) {
    echo $e->getMessage();
}

