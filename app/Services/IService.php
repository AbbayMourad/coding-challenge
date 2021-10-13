<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

interface IService
{
    function create(array $data, array $models);

    function createMany(array $data);

    function getMany(array $conditions, array $options);

    function get(array $conditions);

    function delete(array $conditions);
}
