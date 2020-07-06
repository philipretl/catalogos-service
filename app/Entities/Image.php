<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Company;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = [
        'url',
        'service'
    ];
}
