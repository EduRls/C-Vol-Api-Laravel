<?php

namespace App\Http\Controllers;

use App\Models\MantenimientoMTurbina;
use Illuminate\Http\Request;

class MantenimientoMTurbinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idPlanta)
    {
        try {
            $data = MantenimientoMTurbina::where('id_planta', $idPlanta)->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage() ], 501);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data['id_planta'] = $request['id_planta'];
            $data["id_medidor"] = $request["id_medidor"];
            $data["tipo_mantenimiento"] = $request["tipo_mantenimiento"];
            $data["responsable"] = $request["responsable"];
            $data["estado"] = $request["estado"];
            $data["observaciones"] = $request["observaciones"];

            $res = MantenimientoMTurbina::create($data);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, MantenimientoMTurbina $mantenimientoMTurbina)
    {
        try {
            $data = MantenimientoMTurbina::find($request->id);
            return  response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MantenimientoMTurbina $mantenimientoMTurbina)
    {
        try {
            $data["id_medidor"] = $request["id_medidor"];
            $data["tipo_mantenimiento"] = $request["tipo_mantenimiento"];
            $data["responsable"] = $request["responsable"];
            $data["estado"] = $request["estado"];
            $data["observaciones"] = $request["observaciones"];

            MantenimientoMTurbina::find($request->id)->update($data);
            $res = MantenimientoMTurbina::find($request->id);
            return  response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, MantenimientoMTurbina $mantenimientoMTurbina)
    {
        try {
            $res = MantenimientoMTurbina::find($request->id)->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }
}
