<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    protected $fillable = [
        'url',
        'service'
    ];
}
