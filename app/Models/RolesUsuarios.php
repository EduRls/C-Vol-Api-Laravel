<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesUsuarios extends Model
{
    use HasFactory;

    protected $table = "roles_usuarios";

    protected $fillable = [
        "rol"
    ];

    
}
