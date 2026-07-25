<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class CaregoriesBanners extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'category_banner';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'file','category_id','url','type'
    ];

    
    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

   



}
