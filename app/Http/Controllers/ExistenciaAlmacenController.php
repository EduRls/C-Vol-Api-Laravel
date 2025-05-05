<?php

namespace App\Http\Controllers;

use App\Models\ExistenciaAlmacen;
use Illuminate\Http\Request;

class ExistenciaAlmacenController extends Controller
{
    /**
     * Mostrar todas las existencias registradas para una planta.
     */
    public function index($idAlmacen)
    {
        try {
            $data = ExistenciaAlmacen::with('almacen')
            ->get();

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 501);
        }
    }

    /**
     * Guardar una nueva existencia inicial para un almacén.
     */
    public function store(Request $request)
    {
        try {
            $data = [
                'id_almacen' => $request->id_almacen,
                'volumen_existencia' => $request->volumen_existencia,
                'fecha_medicion' => $request->fecha_medicion
            ];

            $res = ExistenciaAlmacen::create($data);
            return response()->json($res, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Mostrar un registro específico por ID.
     */
    public function show(Request $request)
    {
        try {
            $res = ExistenciaAlmacen::findOrFail($request->id);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'No se encontró el registro.'], 404);
        }
    }

    /**
     * Actualizar un registro de existencia (solo si necesitas permitirlo).
     */
    public function update(Request $request)
    {
        try {
            $data = [
                'volumen_existencia' => $request->volumen_existencia,
                'fecha_medicion' => $request->fecha_medicion
            ];

            ExistenciaAlmacen::findOrFail($request->id)->update($data);
            return response()->json(['message' => 'Registro actualizado correctamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function verificar($id)
    {
        try {
            $existe = ExistenciaAlmacen::where('id_almacen', $id)->exists();
            return response()->json(['existe' => $existe], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


}
