<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProductsExtra extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_extras';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name','state','product_id'
    ];

    
    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function items()
    {
        return $this->hasMany(ProductsExtrasItems::class, 'product_extra_id')->orderBy('id','ASC');
    }



}
