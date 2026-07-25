<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Lottery extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'lottery';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name','email','document','phone','organization','file','state'
    ];

 

    protected $searchable = [
        'columns' => [
          'name.name' => 5,
        ]
    ];

    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

    
    
}
