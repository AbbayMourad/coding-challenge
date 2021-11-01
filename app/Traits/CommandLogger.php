<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait CommandLogger
{
    private function logErrors(string $info, Iterable $errors)
    {
        $this->line($info);
        foreach ($errors as $error) {
            $this->error($error[0]);
        }
    }

    private function modelToString(Model $model): string
    {
        $out = [];
        foreach ($this->loggableFields as $field) {
            $value = $model->$field;
            if ($value) {
                array_push($out, $field . "=" . $model->$field);
            }
        }

        return join(", ", $out);
    }

    private function logModel($model)
    {
        $this->info($this->modelToString($model));
    }
}
