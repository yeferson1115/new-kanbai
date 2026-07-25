<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class CustomRequestHistory extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'custom_request_history';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'custom_request_id','state'
    ];

    
    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function custom()
    {
        return $this->belongsTo(CustomRequest::class, 'custom_request_id');
    }

   

}
