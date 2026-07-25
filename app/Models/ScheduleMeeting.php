<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class ScheduleMeeting extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'schedule_meeting';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name','email','phone','organization'
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

    
    
}
