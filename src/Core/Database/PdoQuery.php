<?php

namespace  App\Core\Database;

use App\Core\Database\interfaces\ConnectionInterface;
use App\Core\Database\interfaces\QueryInterface;
use Exception;
use PDO;
use PDOStatement;

class PdoQuery implements QueryInterface
{
    protected PDO $connection;
    protected string $query = '';
    protected array $bindings = [];

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function select(string $table, array $columns = ['*']): QueryInterface
    {
        $columns = implode(', ', $columns);
        $this->query .= "SELECT {$columns} FROM {$table}";

        return $this;
    }

    public function where(string $column, string $operator, $value): QueryInterface
    {
        $this->query .= " WHERE {$column} {$operator} ?";
        $this->bindings[] = $value;

        return $this;
    }

    public function andWhere(string $column, string $operator, $value): QueryInterface
    {
        $this->query .= " AND {$column} {$operator} ?";
        $this->bindings[] = $value;

        return $this;
    }


    public function orWhere(string $column, string $operator, $value): QueryInterface
    {
        $this->query .= " OR {$column} {$operator} ?";
        $this->bindings[] = $value;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function insert(string $table, array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $this->query = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->bindings = array_values($data);

        $this->execute();

        return $this->getLastInsertId() > 0;
    }

    public function getLastInsertId(): int
    {
        return (int) $this->connection->lastInsertId();
    }

    /**
     * @throws Exception
     */
    public function update(string $table, array $data, array $conditions): bool
    {
        $set = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($data)));
        $where = implode(' AND ', array_map(fn($col) => "{$col} = ?", array_keys($conditions)));
        $this->query = "UPDATE {$table} SET {$set} WHERE {$where}";
        $this->bindings = array_merge(array_values($data), array_values($conditions));

        return $this->execute();
    }

    /**
     * @throws Exception
     */
    public function delete(string $table, array $conditions): bool
    {
        $where = implode(' AND ', array_map(fn($col) => "{$col} = ?", array_keys($conditions)));
        $this->query = "DELETE FROM {$table} WHERE {$where}";
        $this->bindings = array_values($conditions);

        return $this->execute();
    }

    /**
     * @throws Exception
     */
    public function first(): ?array
    {
        $this->query .= " LIMIT 1";

        $statement = $this->executeQuery();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result !== false ? $result : [];


    }

    /**
     * @throws Exception
     */
    public function get(): array
    {
        $statement = $this->executeQuery();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @throws Exception
     */
    protected function executeQuery(): PDOStatement
    {
        try {
            $statement = $this->connection->prepare($this->query);

            $statement->execute($this->bindings);

            // Reset the query and bindings for reuse
            $this->query = '';
            $this->bindings = [];
        } catch (Exception $e) {
            // Handle exception or rethrow
            throw new Exception($e);
        }

        return $statement;
    }

    /**
     * @throws Exception
     */
    public function execute(): bool
    {
        $statement = $this->executeQuery();

        // Reset the query and bindings for reuse
        $this->query = '';
        $this->bindings = [];

        return $statement->rowCount() > 0;
    }
}