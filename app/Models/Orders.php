<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Orders extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'orders';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'email','type_document','document','name_business','name','cellphone','address','city','date_delivery','observation','total','payment_method','reference','vaucher','state'
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
    public function items()
    {
        return $this->hasMany(OrdersItems::class, 'order_id')->orderBy('id','ASC');
    }

    public function adicionales()
    {
        return $this->hasMany(OrdersItemsExtras::class, 'order_id')->orderBy('id','ASC');
    }
    public function timeline()
    {
        return $this->hasMany(OrdersTimeLine::class, 'order_id')->orderBy('id','ASC');
    }

  
}
