<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroEntradasSalidasPipa extends Model
{
    use HasFactory;

    protected $table = "registro_entradas_salidas_pipa";

    protected $fillable = [
        'id_planta',
        'id_pipa',
        "inventario_inical",
        "compra",
        "venta",
        "inventario_final"
    ];

    // Define la relación con el modelo Pipa
    public function pipa()
    {
        return $this->belongsTo(Pipa::class, 'id_pipa', 'id');
    }
}
