<?php

namespace App\Http\Controllers;

use App\Models\mTurbina;
use Illuminate\Http\Request;

class MTurbinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try { 
            $data = mTurbina::get();
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
    public function show(mTurbina $mTurbina)
    {
        try { 
            $data = mTurbina::find($id);
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
            $data['modelo_equipo'] = $request['modelo_equipo'];
            $data['rango_flujo'] = $request['rango_flujo'];
            $data['rango_temperatura'] = $request['rango_temperatura'];
            $data['numero_serie'] = $request['numero_serie'];
            $data['precision'] = $request['precision'];
            $data['suministro_energia'] = $request['suministro_energia'];
            $data['salida_modelo'] = $request['salida_modelo'];
            $data['fecha'] = $request['fecha'];

            mTurbina::find($id)->update($data);
            $res = mTurbina::find($id);
            return response()->json( $res , 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(mTurbina $mTurbina)
    {
        try {       
            $res = mTurbina::find($id)->delete(); 
            return response()->json([ "deleted" => $res ], 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }

    public function getInformacion(mTurbina $mTurbina)
    {
        
    }
}
