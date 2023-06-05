<?php

namespace App\Core\Model;

use App\Core\Database\QueryFactory;

class BaseModel
{
    protected QueryFactory $pdoQuery;
    protected string $table;

    protected array $attributes = [];
    public function __construct(QueryFactory $pdoQuery)
    {
        $this->pdoQuery = $pdoQuery;
    }

    public function load($data): void
    {
        $this->attributes = array_merge($this->attributes, $data);
    }
    public function save(): bool
    {
        if (isset($this->attributes['id'])) {
            return $this->pdoQuery->createQuery()->update($this->table, $this->attributes, ['id' => $this->attributes['id']]);
        } else {
            return $this->pdoQuery->createQuery()->insert($this->table, $this->attributes);
        }
    }
}