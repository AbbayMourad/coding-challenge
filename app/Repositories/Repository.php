<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class Repository
{
    private string $modelName;

    private int $defaultPerPage = 5;

    public function __construct(?string $modelName, string $namespace = '\App\Models')
    {
        $this->modelName = $namespace.'\\'.$modelName;
    }

    public function getMany(array $conditions = [], array $sortOptions = []): LengthAwarePaginator
    {
        $query = $this->modelName::where($conditions);
        $sortOptions = $this->filterSortOptions($sortOptions);
        $this->orderBy($query, $sortOptions);

        return $query->paginate($this->perPage ?? $this->defaultPerPage);
    }

    public function getManyByIds(array $ids): Collection
    {
        return $this->modelName::whereIn('id', $ids)->get();
    }

    public function delete($id)
    {
        return $this->modelName::destroy($id);
    }

    protected function orderBy($query, array $sortOptions) {
        foreach ($sortOptions as $field => $order) {
            $query->orderBy($field, $order);
        }
    }

    protected function isAllowedField($field): bool
    {
        return in_array($field, $this->allowedFields);
    }

    protected function filterData(array $data): array
    {
        $isAllowedField = function ($field) {
            return $this->isAllowedField($field);
        };

        return array_filter($data, $isAllowedField, ARRAY_FILTER_USE_KEY);
    }

    protected function isSortableField($field): bool
    {
        return in_array($field, $this->sortableFields);
    }

    protected function filterSortOptions($sortOptions): array
    {
        $isSortableField = function ($field) {
            return $this->isSortableField($field);
        };

        return array_filter($sortOptions, $isSortableField, ARRAY_FILTER_USE_KEY);
    }
}
