<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acupoint extends Model
{
    //
    protected $fillable = [
        'name', 'parts', 'is_enabled',
    ];
}
