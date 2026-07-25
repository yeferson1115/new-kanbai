<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Vinkla\Hashids\Facades\Hashids;

use App\Notifications\CustomResetPasswordNotification;
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'lastname', 'email', 'password', 'status','username','genero','name_business','phone','charge','business_id','document','whatsapp','cellphone','description','photo'
    ];

    protected $hidden = [];

    protected $appends = ['full_name'];


    protected $searchable = [
        'columns' => [
          'users.name' => 5,
          'users.lastname' => 5,
        ]
    ];

    protected $guard_name = 'web';

    /*
    |
    | ** Relationships model **
    |
    */

    public function logins()
    {
        return $this->hasMany('App\Models\Login','user_id');
    }

    /*
    |
    | ** Accesors model **
    |
    */

     public function getDisplayNameAttribute()
     {
         return trim(str_replace( '  ', ' ',  "{$this->name} {$this->lastname}")) ;
     }


    public function getDisplayStatusAttribute()
    {
        return $this->status == 1 ? 'Activo' : 'Denegado';
    }

    public function getFullNameAttribute()
{
    return $this->name . ' ' . $this->lastname;
}
    /*
    |
    | ** Mutators model **
    |
    */

    public function setPasswordAttribute($attribute)
    {
        if (! empty($attribute))
        {
           $this->attributes['password'] = strlen($attribute) < 60 ? bcrypt($attribute) : $attribute;
        }
    }

    /*
    |
    | ** Send the custom password reset notification **
    |
    */

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }
   
    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

   public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

}
