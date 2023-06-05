<?php

namespace  App\Core\Database\interfaces;

interface QueryInterface
{
    public function select(string $table, array $columns = ['*']): self;

    public function where(string $column, string $operator, $value): self;

    public function andWhere(string $column, string $operator, $value): self;

    public function orWhere(string $column, string $operator, $value): self;

    public function insert(string $table, array $data): bool;

    public function update(string $table, array $data, array $conditions): bool;

    public function delete(string $table, array $conditions): bool;

    public function first(): ?array;

    public function get(): array;

    function execute(): bool;
}