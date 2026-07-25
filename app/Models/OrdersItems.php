<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class OrdersItems extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'orders_items';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'order_id','product_id','quantity','price_unit','commerce_id','color_id','talla_id'
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

    public function producto()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function comercio()
    {
        return $this->belongsTo(User::class, 'commerce_id');
    }
    public function color()
    {
        return $this->belongsTo(ProductsColor::class, 'color_id');
    }
    public function talla()
    {
        return $this->belongsTo(ProductsTallas::class, 'talla_id');
    }

    public function extras()
    {
        return $this->hasMany(OrdersItemsExtras::class, 'order_item_id')->orderBy('id','ASC');
    }
    
  
}
