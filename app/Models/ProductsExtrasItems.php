<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProductsExtrasItems extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_extras_items';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_extra_id','name','price'
    ];

   
        
    protected $searchable = [
        'columns' => [
          'name.title' => 5,
        ]
    ];

    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function extra()
    {
        return $this->belongsTo(ProductsExtra::class, 'product_extra_id');
    }
    public function values()
    {
        return $this->hasMany(ProductsExtrasItemsValues::class, 'products_extras_items_id');
    }
  
}
