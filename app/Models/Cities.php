<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cities';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code','name','code_departament'
    ];


}
