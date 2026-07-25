<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProductQuotationItemsExtra extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_quotation_items_extras';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_quotation_id','product_quotation_item_id','extra_id','price','quantity'
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
