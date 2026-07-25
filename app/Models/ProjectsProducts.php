<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProjectsProducts extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'projects_products';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'project_id','producto','price','quantity','imagen','color_id','talla_id','product_id'
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
        return $this->hasMany(ProjectsProductsExtras::class, 'project_item_id')->orderBy('id','ASC');
    }
    
    
}
