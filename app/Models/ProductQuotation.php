<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProductQuotation extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_quotation';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'email','name','type_document','document','name_business','city','user_id','cellphone','quantity','address','date_delivery','observations','state','version','enviado','price_finish','price_shiping','comment','deny','user_request_id','file','iva','deny_customer','total','channel','plazo','uid','totalextras'
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

    public function history()
    {
        return $this->hasMany(ProductQuotationHistory::class, 'quotation_id')->orderBy('id','ASC');
    }

    public function items()
    {
        return $this->hasMany(ProductQuotationItems::class, 'productquotation_id')->orderBy('id','ASC');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function adicionales()
    {
        return $this->hasMany(ProductQuotationItemsExtra::class, 'product_quotation_id')->orderBy('id','ASC');
    }

}
