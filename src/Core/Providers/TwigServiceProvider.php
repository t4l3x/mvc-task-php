<?php

namespace App\Core\Providers;

use App\Core\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigServiceProvider implements ServiceProviderInterface
{
    public function register(): array
    {
        return [
            Environment::class => function (ContainerInterface $c) {
                $loader = new FilesystemLoader(__DIR__ . '/../../View');
                return new Environment($loader, [
                    'cache' => __DIR__ . '/../../var/cache/twig',
                    'debug' => true,
                ]);
            },
        ];
    }
}