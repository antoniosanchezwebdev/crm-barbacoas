<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'titulo',
        'descripcion',
        'trabajador_id',
        'parte_id',
        'tiempo_estimado',
        'tiempo_real',
        'estado',
        'precio',
        'materiales',
    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'trabajador_id');
    }
    public function partesTrabajo()
    {
        return $this->belongsTo(PartesTrabajo::class, 'trabajo_id');
    }

    public function logs()
    {
        return $this->hasMany(TrabajoLog::class, 'trabajo_id');
    }
    public function logsEnCurso()
    {
        return $this->hasMany(TrabajoLog::class, 'trabajo_id')->where('estado', 'En curso');
    }

}
