<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departaments extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'departaments';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code','name'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customers');
    }
}
