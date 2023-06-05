<?php

namespace App\Model;

use App\Core\Model\BaseModel;

class PostModel extends BaseModel
{
    protected string $table = 'posts';

    protected array $fillable = ['unique_id', 'data'];

    public function storeData($data): bool
    {
        $data = array_intersect_key($data, array_flip($this->fillable));
        $data['unique_id'] = uniqid();
        $this->load($data);
        return $this->save();
    }

    public function getData($uniqueId): static
    {
        $record = $this->pdoQuery->createQuery()->select($this->table)->where('unique_id', '=', $uniqueId)->first();
        $this->load($record);
        return $this;
    }

    public function getAllData(): array
    {
        return $this->pdoQuery->createQuery()->select($this->table)->get();
    }

}