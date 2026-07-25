<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProductsSubcategories extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'products_subcategories';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'subcategory_id','product_id'
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

    public function subcategory()
    {
        return $this->belongsTo(SubCategories::class, 'subcategory_id');
    }

   
}
