<?php

namespace App\Traits;

use phpDocumentor\Reflection\Types\Iterable_;

trait CommandLogger
{
    private function logErrors(string $info, Iterable $errors)
    {
        $this->info($info);
        foreach ($errors as $error) {
            $this->error($error);
        }
    }

    private function modelToString($model)
    {
        $out = [];
        foreach ($this->loggableFields as $field) {
            array_push($out, $field."=".$model->$field);
        }
        return join(", ", $out);
    }

    private function logModel($model)
    {
        $this->info($this->modelToString($model));
    }
}
