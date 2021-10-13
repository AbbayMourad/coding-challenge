<?php

namespace App\Repositories;

abstract class Repository implements IRepository
{
    protected string $modelName;

    public function __construct(string $modelName, string $modelsPrefix = 'App\Models') {
        $this->modelName = $modelsPrefix."\\".$modelName;
    }

    public function get(array $conditions) {
        return $this->modelName::where($conditions)->first();
    }

    public function getMany(array $conditions, array $options)
    {
        return $this->modelName::where($conditions)->get();
    }

    public function getOrCreate(array $conditions, array $options = []) {
        return $this->modelName::firstOrCreate($conditions, $options['extra'] ?? []);
    }

    public function create(array $models) {
        $model = $models[0];
        $model->save();
        return $model;
    }

    public function createMany(array $data) {
        $models = [];
        foreach ($data as $values) {
            $model = new $this->modelName($values);
            $model->save();
            array_push($models, $model);
        }
        return $models;
    }

    public function delete(array $conditions)
    {
        $model = $this->modelName::where($conditions)->firstOrFail();
        $model->delete();
        return $model;
    }

    public function getModelName(): string
    {
        return $this->modelName;
    }

    protected function filterSortOptions(array $options): array
    {
        $result = [];
        foreach ($this->modelName::getSortableFields() as $field) {
            if (!isset($options["sort-$field"])) continue;
            $result[$field] = $options["sort-$field"];
        }
        return $result;
    }


}
