<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Categories extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'categories';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name','slug','file','state','is_menu'
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

    public function subcategories()
    {
        return $this->hasMany(SubCategories::class, 'category_id');
    }

    public function banners()
    {
        return $this->hasMany(CaregoriesBanners::class, 'category_id');
    }

    public function bannerscommerce()
    {
        return $this->hasMany(CaregoriesCommercialBanners::class, 'category_id');
    }

    public function imagesattributes()
    {
        return $this->hasMany(CaregoriesImagesAttributes::class, 'category_id');
    }
    
}
