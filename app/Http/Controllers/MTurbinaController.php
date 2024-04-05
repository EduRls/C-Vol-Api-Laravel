<?php

namespace App\Http\Controllers;

use App\Models\mTurbina;
use Illuminate\Http\Request;

class MTurbinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idPlanta)
    {
        try { 
            $data = mTurbina::where('id_planta', $idPlanta)->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data['id_planta'] = $request['id_planta'];
            $data['modelo_equipo'] = $request['modelo_equipo'];
            $data['rango_flujo'] = $request['rango_flujo'];
            $data['rango_temperatura'] = $request['rango_temperatura'];
            $data['numero_serie'] = $request['numero_serie'];
            $data['precision'] = $request['precision'];
            $data['suministro_energia'] = $request['suministro_energia'];
            $data['salida_modelo'] = $request['salida_modelo'];
            $data['fecha'] = $request['fecha'];
            
            $res = mTurbina::create($data);
            return response()->json( $res, 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,mTurbina $mTurbina)
    {
        try { 
            $data = mTurbina::find($request->id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, mTurbina $mTurbina)
    {
        try {
            $data['id_planta'] = $request['id_planta'];
            $data['modelo_equipo'] = $request['modelo_equipo'];
            $data['rango_flujo'] = $request['rango_flujo'];
            $data['rango_temperatura'] = $request['rango_temperatura'];
            $data['numero_serie'] = $request['numero_serie'];
            $data['precision'] = $request['precision'];
            $data['suministro_energia'] = $request['suministro_energia'];
            $data['salida_modelo'] = $request['salida_modelo'];
            $data['fecha'] = $request['fecha'];

            mTurbina::find($request->id)->update($data);
            $res = mTurbina::find($request->id);
            return response()->json( $res , 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, mTurbina $mTurbina)
    {
        try {       
            $res = mTurbina::find($request->id)->delete(); 
            return response()->json([ "deleted" => $res ], 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }

    public function getInformacion(mTurbina $mTurbina)
    {
        
    }
}
