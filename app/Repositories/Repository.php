<?php

namespace App\Repositories;

abstract class Repository
{
    protected function filterData(array $data): array
    {
        $isAllowedField = function ($field) {
            return $this->isAllowedField($field);
        };

        return array_filter($data, $isAllowedField, ARRAY_FILTER_USE_KEY);
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
        $isSortableField = function ($field) {
            return $this->isSortableField($field);
        };

        return array_filter($sortOptions, $isSortableField, ARRAY_FILTER_USE_KEY);
    }
}
