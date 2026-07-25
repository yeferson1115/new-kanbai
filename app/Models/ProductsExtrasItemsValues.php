<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsExtrasItemsValues extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_extras_items_values';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'products_extras_items_id',
        'qty_min',
        'qty_max',
        'price'
    ];

    public function item()
    {
        return $this->belongsTo(ProductsExtrasItems::class, 'products_extras_items_id');
    }
}
