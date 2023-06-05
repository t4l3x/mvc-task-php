<?php

namespace  App\Core\Database\interfaces;

interface ConnectionInterface
{
    public function connect(): ?\PDO;
    public function disconnect(): void;
}