<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProductQuotationItems extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_quotation_item';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_id','productquotation_id','commerce_id','price','quantity','color_id','talla_id'
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
        return $this->hasMany(ProductQuotationItemsExtra::class, 'product_quotation_item_id')->orderBy('id','ASC');
    }

}
