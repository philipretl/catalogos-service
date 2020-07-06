<?php

namespace App\Actions\Shared;

use App\Actions\Shared\StoreImageAction;
use App\Entities\Image;

class AttachImagesModelAction{

    /**
     * @param array $data
     * @param string $folder
     * @param EloquentModel $model
     * @param int $model_id
     * @return void
     */
    public static function execute($data, $folder, $model_name, $entity):void{

        if (array_key_exists('image',$data)){
            self::createImage($data['image'], $entity, $folder, $model_name);
            return;
        }

        $images = $data['images'];
        foreach($images as $image){
            self::createImage($image, $entity, $folder, $model_name);
        }
        return;
    }

    private static function createImage($image, $entity, $folder, $model_name):void{
        
        $url = StoreImageAction::execute($image, $folder, $model_name);
        $image = Image::create([
            'url' => $url,
        ]);
        $entity->images()->attach($image);
        return;
    }
}
