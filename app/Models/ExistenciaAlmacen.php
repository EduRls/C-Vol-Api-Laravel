<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExistenciaAlmacen extends Model
{
    use HasFactory;

    protected $table = 'existencias_almacen';

    protected $fillable = [
        'id_almacen',
        'volumen_existencia',
        'fecha_medicion'
    ];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen', 'id');
    }
}
