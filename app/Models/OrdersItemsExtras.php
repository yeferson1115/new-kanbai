<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class OrdersItemsExtras extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'orders_items_extras';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'order_id','order_item_id','extra_id','price','quantity'
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

    public function itemextra()
    {
        return $this->belongsTo(ProductsExtrasItems::class, 'extra_id');
    }

  
}
