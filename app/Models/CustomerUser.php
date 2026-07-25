<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class CustomerUser extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'customer_user';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'customer_user_id','user_id','whatsapp','description'
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

    public function asesor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cliente()
    {
        return $this->belongsTo(User::class, 'customer_user_id');
    }
}
