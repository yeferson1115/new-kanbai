<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Vinkla\Hashids\Facades\Hashids;

class Payment extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'payment';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'customer_id', 'project_id','status','paymentMethodType','reference','transactionid'
    ];
    protected $guard_name = 'web';

    /*public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }*/
}
