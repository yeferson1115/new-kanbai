<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProductsPriceRange extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'products_price_range';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_id','quantity_min','quantity_max','price'
    ];

    
    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

   



}
