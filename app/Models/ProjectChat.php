<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProjectChat extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'projects_message';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'project_id','message','file','type_sender','state'
    ];

    
    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

   



}
