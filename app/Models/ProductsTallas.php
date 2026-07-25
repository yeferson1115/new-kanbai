<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProductsTallas extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_tallas';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_id','talla'
    ];

    
    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

   



}
