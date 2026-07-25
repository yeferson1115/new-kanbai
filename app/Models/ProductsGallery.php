<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProductsGallery extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_gallery';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'file','product_id'
    ];

    
    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

   



}
