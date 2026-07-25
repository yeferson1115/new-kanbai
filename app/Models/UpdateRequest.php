<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 

class UpdateRequest extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'update_requests';

    protected $fillable = [
        'project_id',
        'vendedor_id',
        'correo_vendedor',        
        'fecha_limite',
        'estado',
        'uid'
    ];

    protected $casts = [
        'fecha_limite' => 'datetime'
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class);
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uid)) {
                $model->uid = $model->generateUniqueUid();
            }
        });
    }

    /**
     * Generar un UID único
     */
    public function generateUniqueUid()
    {
        do {
            // Formato: UPD-XXXXXX (donde X son caracteres alfanuméricos)
            $uid = 'UPD-' . strtoupper(Str::random(6));
        } while (self::where('uid', $uid)->exists());

        return $uid;
    }

     public static function findByUid($uid)
    {
        return self::where('uid', $uid)->first();
    }
}