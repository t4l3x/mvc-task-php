<?php
namespace  App\Core\Database;

use App\Core\Database\interfaces\ConnectionInterface;

readonly class PdoConnectionFactory
{
    public function __construct(
        private string $host,
        private string $db,
        private string $user,
        private string $pass
    ) {}

    public function createConnection(): \PDO
    {
        return (new PdoConnection($this->host, $this->db, $this->user, $this->pass))->connect();
    }
}