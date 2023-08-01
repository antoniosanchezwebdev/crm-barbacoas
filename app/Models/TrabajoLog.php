<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrabajoLog extends Model
{
    use HasFactory;
    protected $table = "trabajos_log";

    protected $fillable = [
        'trabajador_id',
        'trabajo_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
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
    public function trabajos()
    {
        return $this->belongsTo(Trabajo::class, 'tarea_id');
    }

    public function partesTrabajo()
    {
        return $this->belongsTo(PartesTrabajo::class, 'tarea_id');
    }
}
