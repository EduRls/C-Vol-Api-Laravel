<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantaGas extends Model
{
    use HasFactory;

    protected $table = "planta_gas";

    protected $fillable = [
        'id_planta',
        "nombre_planta"
    ];
}
