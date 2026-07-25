<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Products extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'products';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id','name','price','quantity_min','delivery_time','shipping_price','description','shipping_free','user_id','state','views','new','easybuy','iva','packaging_unit_quantity'
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
    public function gallery()
    {
        return $this->hasMany(ProductsGallery::class, 'product_id')->orderBy('id','ASC');
    }
    

    public function questions()
    {
        return $this->hasMany(ProductsQuestions::class, 'product_id');
    }

    public function escalas()
    {
        return $this->hasMany(ProductsPriceRange::class, 'product_id')->orderBy('quantity_min', 'asc');
    }

    

    public function productcategories()
    {
        return $this->hasMany(ProductsCategories::class, 'product_id');
    }

    public function category()
    {
        return $this->productcategories->belongsTo(Categories::class,'category_id');
    }

    public function productsubcategories()
    {
        return $this->hasMany(ProductsSubcategories::class, 'product_id');
    }

    public function subcategory()
    {
        return $this->productsubcategories->belongsTo(SubCategories::class,'subcategory_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function colores()
    {
        return $this->hasMany(ProductsColor::class, 'product_id');
    }

    public function tallas()
    {
        return $this->hasMany(ProductsTallas::class, 'product_id');
    }

    public function adicional()
    {
        return $this->hasMany(ProductsAdditional::class, 'product_id');
    }

    public function extras()
    {
        return $this->hasMany(ProductsExtra::class, 'product_id');
    }
    

    
}
