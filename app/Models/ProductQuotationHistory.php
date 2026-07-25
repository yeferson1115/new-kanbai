<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProductQuotationHistory extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_quotation_history';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'quotation_id','state'
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

   

}
