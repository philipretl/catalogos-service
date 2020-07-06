<?php

namespace App\Actions\Shared;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Entities\Image;

class StoreImageAction{

    public static function execute($image, $folder, $path):string{
        $url='';
        $path = strtolower(str_replace(' ','_',$path));
        $folder = strtolower(str_replace(' ','_',$folder));
        $url= Storage::putfile('public/images/'.$folder.'/'.$path, $image);
        $url = env('API_URL').str_replace('public','',$url);
        return $url;
    }
}
