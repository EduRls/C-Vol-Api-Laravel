<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformacionMedidor;

class InformacionMedidorController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index($idPlanta)
    {
        try {
            $data = InformacionMedidor::where('id_planta', $idPlanta)->get();
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
            $data["id_medidor"] = $request["id_medidor"];
            $data["informacion_medidor"] = $request["informacion_medidor"];

            $res = InformacionMedidor::create($data);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, InformacionMedidor $informacionMedidor)
    {
        try {
            $data = InformacionMedidor::find($request->id);
            return  response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformacionMedidor $informacionMedidor)
    {
        try {
            $data['id_planta'] = $request['id_planta'];
            $data["id_medidor"] = $request["id_medidor"];
            $data["informacion_medidor"] = $request["informacion_medidor"];

            InformacionMedidor::find($request->id)->update($data);
            $res = InformacionMedidor::find($request->id);
            return  response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, InformacionMedidor $informacionMedidor)
    {
        try {
            $res = InformacionMedidor::find($request->id)->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }
}
