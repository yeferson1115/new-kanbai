<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Business extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'business';
    protected $dates = ['deleted_at'];

    protected $fillable = [
         'company_name','nit','billing_email','address','department_id','city_id','state','user_id','term'
    ];

   
       
    

    protected $searchable = [
        'columns' => [
          'company_name.company_name' => 5,
        ]
    ];

    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function departaments()
    {
        return $this->belongsTo(Departaments::class, 'department_id');
    }

    public function cities()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }
    public function asesor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
