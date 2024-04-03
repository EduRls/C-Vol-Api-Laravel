<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionMedidor extends Model
{
    use HasFactory;

    protected $table = "informacion_medidor";

    protected $fillable = [ 
        'id_medidor', 
        'informacion_medidor',
    ];
}
