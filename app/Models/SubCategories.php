<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class SubCategories extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'subcategories';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name','slug','file','state','category_id'
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
    public function banners()
    {
        return $this->hasMany(SubCategoriesBanners::class, 'subcategory_id');
    }
}
