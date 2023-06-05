<?php

namespace App\Core\Providers;



use App\Core\Database\PdoConnectionFactory;
use App\Core\Database\QueryFactory;
use Psr\Container\ContainerInterface;


class DatabaseServiceProvider implements ServiceProviderInterface
{

    public function register(): array
    {
        return [
                PdoConnectionFactory::class => function () {
        return new PdoConnectionFactory('db', 'post', 'root', '');
    },
    QueryFactory::class => function (ContainerInterface $c) {
        $pdoConnectionFactory = $c->get(PdoConnectionFactory::class);
        return new QueryFactory($pdoConnectionFactory);
    },

        ];
    }
}