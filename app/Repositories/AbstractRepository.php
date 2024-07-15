<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use InvalidArgumentException;

abstract class AbstractRepository
{
    protected string $modelClass;

    public function __construct()
    {
        $modelName = Str::replace('Repository', '', class_basename($this));

        $this->modelClass = 'App\\Models\\' . $modelName;
    }

    public function all(): Collection
    {
        return $this->modelClass::all();
    }

    public function first(): ?Model
    {
        return $this->modelClass::first();
    }

    public function find(int $id): ?Model
    {
        return $this->modelClass::find($id);
    }

    public function create(array $data): Model
    {
        $model = $this->modelClass::create($data);

        return $model;
    }

    public function update(Model $model, array $data): Model
    {
        if (get_class($model) !== $this->modelClass) {
            throw new InvalidArgumentException('Invalid model given');
        }

        $model->fill($data);

        if ($model->isDirty()) {
            $model->save();
        }

        return $model;
    }

    public function delete(Model $model): void
    {
        if (get_class($model) !== $this->modelClass) {
            throw new InvalidArgumentException('Invalid model given');
        }

        $model->delete();
    }
}
