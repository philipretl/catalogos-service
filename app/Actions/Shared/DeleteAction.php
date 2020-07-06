<?php

namespace App\Actions\Shared;

use Venoudev\Results\Exceptions\NotFoundException;

class DeleteAction{

    public static function execute($model, int $model_id, bool $hard_delete){

        $entity = $model::find($model_id);
        if ($entity == null){
            $exception = new NotFoundException();
            throw $exception;
        }

        if($hard_delete == false){
            $entity->delete();
            return;
        }
        $entity->forceDelete();
        return;
    }
}
