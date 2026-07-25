<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProductsCategories extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'products_categories';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'category_id','product_id'
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

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function products()
    {
        return $this->belongsTo(Products::class,'product_id');
    }

   
}
