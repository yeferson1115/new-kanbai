<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Customers extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'customers';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'email','phone','type','identification','identification_type','regimen','address_line','first_name','last_name','departament_id','city_id','user_id'
    ];







    protected $searchable = [
        'columns' => [
          'name.name' => 5,
          'price.lastname' => 5,
          'state.lastname' => 5,
        ]
    ];

    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function departaments()
    {
        return $this->belongsTo(Departaments::class, 'departament_id');
    }

    public function cities()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class,'customer_id');
    }


}
