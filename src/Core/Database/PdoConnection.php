<?php

namespace App\Core\Database;

use App\Core\Database\Exceptions\DatabaseConnection;
use App\Core\Database\interfaces\ConnectionInterface;
use PDO;
use PDOException;
use function PHPUnit\Framework\exactly;

class PdoConnection implements ConnectionInterface
{
    private ?PDO $connection = null;

    public function __construct(
        private readonly string $host,
        private readonly string $db,
        private readonly string $user,
        private readonly string $pass
    )
    {
    }

    /**
     * @throws DatabaseConnection
     */
    public function connect(): ?PDO
    {
        return $this->connection ??= $this->createConnection();
    }

    /**
     * @throws DatabaseConnection
     */
    private function createConnection(): PDO
    {

        try {
            return new PDO(
                "mysql:host={$this->host};dbname={$this->db}",
                $this->user,
                $this->pass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false]
            );

        } catch (PDOException $e) {

            throw new DatabaseConnection('Failed to connect to the database: ' . $e->getMessage());
        }
    }

    public function disconnect(): void
    {
        $this->connection = null;
    }
}