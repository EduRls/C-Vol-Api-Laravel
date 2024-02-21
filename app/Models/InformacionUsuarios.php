<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionUsuarios extends Model
{
    use HasFactory;

    protected $table = "informacion_usuarios";

    protected $fillable = [
        "id_user",
        "nombre_usuario",
        "apellido_paterno",
        "apellido_materno"
    ];
}
