<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartesTrabajo extends Model
{
    use HasFactory;

    protected $table = "partes_trabajos";

    protected $fillable = [
        'titulo',
        'fecha',
        'id_cliente',
        'observaciones',
        'trabajos_realizar',
        'operarios',
        'descripcion',
        'documentos',
        'estado',
        'firma',
        'precio'
    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

}
