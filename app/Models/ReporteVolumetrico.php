<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteVolumetrico extends Model
{
    use HasFactory;

    protected $table = "reportes_volumetricos";

    protected $fillable = [
        'id_planta',
        "reporte"
    ];
}
