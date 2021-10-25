<?php

namespace App\Repositories;

abstract class Repository
{
    protected function filterData(array $data): array
    {
        return array_filter($data, function ($field) {
            return $this->isAllowedField($field);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function isAllowedField($field): bool
    {
        return in_array($field, $this->allowedFields);
    }

    protected function isSortableField($field): bool
    {
        return in_array($field, $this->sortableFields);
    }

    protected function filterSortOptions($sortOptions): array
    {
        return array_filter($sortOptions, function ($field) {
            return $this->isSortableField($field);
        }, ARRAY_FILTER_USE_KEY);
    }
}
