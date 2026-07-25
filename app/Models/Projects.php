<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Projects extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'projects';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'no_project','customer','date_shopping','bussine_id','email_customer','email_customer2','asesor','phone_asesor','information_shopping','state','imagenes','videos','guia','empresa','seller_id','easybuy','vaucher','total','document','cellphone','address','city','payment_method','date_finish','status_wompi','reference','user_id'
    ];

    protected $casts = [
        'imagenes' => 'array',
        'videos' => 'array',
    ];
  
    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function timeline()
    {
        return $this->hasMany(ProjectTimeLine::class, 'project_id')->orderBy('id','ASC');
    }

    public function productos()
    {
        return $this->hasMany(ProjectsProducts::class, 'project_id')->orderBy('id','ASC');
    }


    public function chat()
    {
        return $this->hasMany(ProjectChat::class, 'project_id')->orderBy('id','ASC');
    }

    public function comercio()
    {
        return $this->belongsTo(Business::class, 'seller_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Business::class, 'bussine_id');
    }


    public function updates()
    {
        return $this->hasMany(ProjectUpdates::class, 'project_id')->orderBy('id','ASC');
    }
    public function adicionales()
    {
        return $this->hasMany(ProjectsProductsExtras::class, 'project_id')->orderBy('id','ASC');
    }

    public function updateRequests()
    {
        return $this->hasMany(UpdateRequest::class, 'project_id');
    }

}
