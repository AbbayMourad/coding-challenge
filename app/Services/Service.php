<?php

namespace App\Services;

use App\Repositories\Repository;

abstract class Service implements IService
{
    protected Repository $repository;
    protected string $modelName;

    public function __construct(Repository $repository) {
        $this->repository = $repository;
        $this->modelName = $repository->getModelName();
    }

    public function createMany(array $data): array {
        return $this->repository->createMany($data);
    }

    public function create(array $data, array $models = []) {
        $model = new $this->modelName($data);
        return $this->repository->create([ $model ]);
    }

    public function get(array $conditions) {
        return $this->repository->get($conditions);
    }

    public function getMany(array $conditions = [], array $options = []) {
        return $this->repository->getMany($conditions, $options);
    }

    public function delete(array $conditions) {
        return $this->repository->delete($conditions);
    }

}
