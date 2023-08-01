<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartesLog extends Model
{
    use HasFactory;
    protected $table = "partes_log";

    protected $fillable = [
        'tarea_id',
        'trabajador_id',
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

    public function partesTrabajo()
    {
        return $this->belongsTo(PartesTrabajo::class, 'tarea_id');
    }
}
