<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Entities\Company;
use App\Entities\File;

class Catalog extends Model
{
    use SoftDeletes;

    protected $table = 'catalogs';
    protected $fillable = [
        'campaing',
        'start_date',
        'pages',
        'finish_date',
        'limit_order_date'
    ];

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function images(){
        return $this->belongsToMany(Image::class, 'company_id',
            'image_company', 'company_id', 'image_id');
    }
}
