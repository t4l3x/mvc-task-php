<?php

namespace App\Core\Database;

use  App\Core\Database\interfaces\QueryInterface;
use App\Core\Database\PdoConnectionFactory;

class QueryFactory
{

    private PdoConnectionFactory $connectionFactory;

    public function __construct(PdoConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    public function createQuery(): QueryInterface
    {
        $connection = $this->connectionFactory->createConnection();

        return new PdoQuery($connection);
    }

}