<?php

namespace App\Core\Providers;

use App\Core\Container\ContainerInterface;

interface ServiceProviderInterface
{
    public function register(): array;

}