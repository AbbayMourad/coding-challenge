<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
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

    /**
     * @return int the number of deleted models, in this case 0 or 1
     */
    public function delete($id): int
    {
        return $this->modelName::destroy($id);
    }

    /**
     * @param Builder|Relation $query
     */
    protected function orderBy($query, array $sortOptions)
    {
        foreach ($sortOptions as $field => $order) {
            $query->orderBy($field, $order);
        }
    }

    protected function isAllowedField(string $field): bool
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

    protected function isSortableField(string $field): bool
    {
        return in_array($field, $this->sortableFields);
    }

    protected function filterSortOptions(array $sortOptions): array
    {
        $isSortableField = function ($field) {
            return $this->isSortableField($field);
        };

        return array_filter($sortOptions, $isSortableField, ARRAY_FILTER_USE_KEY);
    }
}
