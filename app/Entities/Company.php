<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Entities\Image;
use App\Entities\Catalog;

class Company extends Model
{
    use SoftDeletes;

    protected $table = 'companies';
    protected $fillable = [
        'name',
        'description'
    ];

    public function images(){
        return $this->belongsToMany(Image::class,
            'image_company', 'company_id', 'image_id');
    }

    public function catalogs(){
        return $this->hasMany(Catalog::class, 'company_id');
    }

}
