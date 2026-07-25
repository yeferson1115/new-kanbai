<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProductsAdditional extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_additional';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_id','product_extra_id'
    ];

    
    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function extra()
    {
        return $this->belongsTo(ProductsExtra::class, 'product_extra_id');
    }



}
