<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;


class CategoryRepository extends Repository
{
    private string $table = 'categories';

    protected array $allowedFields = ['name'];

    public function create(array $categoryData, $parentCategory = null)
    {
        $categoryData = $this->filterData($categoryData);
        if ($parentCategory) $categoryData['parent_id'] = $parentCategory->id;
        $id = DB::table($this->table)->insertGetId($categoryData);
        return $this->get(['id' => $id]);
    }

    public function get(array $conditions)
    {
        return DB::table($this->table)->where($conditions)->first();
    }

    public function getOrCreate(array $conditions, array $categoryData)
    {
        $category = $this->get($conditions);
        if ($category)  return $category;
        return $this->create($categoryData);
    }

    public function getMany(array $conditions)
    {
        return DB::table($this->table)->where($conditions)->get();
    }

    public function delete($id)
    {
        return DB::table($this->table)->where(['id' => $id])->delete();
    }
}
