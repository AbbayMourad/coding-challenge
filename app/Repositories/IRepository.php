<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface IRepository
{
   function get(array $conditions);

   function getMany(array $conditions, array $options);

   function getOrCreate(array $conditions, array $options);

   function create(array $models);

   function createMany(array $data);

   function delete(array $conditions);

   function getModelName() : string;
}
