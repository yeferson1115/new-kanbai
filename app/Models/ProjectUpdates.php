<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ProjectUpdates extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'project_updates';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'project_id','description','file'
    ];

    
    protected $guard_name = 'web';

    public function getEncodeIDAttribute()
    {
        return Hashids::encode($this->id);
    }

   



}
