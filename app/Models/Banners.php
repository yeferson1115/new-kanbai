<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Banners extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'banners';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'imagedesk','imagemobile','url_mobile','url_desk'
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
