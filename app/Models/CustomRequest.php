<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class CustomRequest extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'custom_request';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_request_id' ,'email','cellphone' ,'name','name_business','quantity' ,'date_delivery' ,'budget_unit' ,'delivery_method' ,'date_delivery_agreed' ,'date_confirmed' ,'shipping_from' ,'category_id' ,'observations' ,'file' ,'state' ,'price_finish' ,'product','date_delivery_ok' ,'price_shiping' ,'image','filepdf','iva'
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

    public function history()
    {
        return $this->hasMany(CustomRequestHistory::class, 'custom_request_id')->orderBy('id','ASC');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_request_id');
    }

    public function gallery()
    {
        return $this->hasMany(CustomRequestGallery::class, 'custom_id')->orderBy('id','ASC');
    }

   

}
