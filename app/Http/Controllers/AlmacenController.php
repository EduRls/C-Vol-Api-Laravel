<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idPlanta)
    {
        try {
            $data = Almacen::where('id_planta', $idPlanta)->get();
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
            $data["id_planta"] = $request["id_planta"];
            $data["clave_almacen"] = $request["clave_almacen"];
            $data["localizacion_descripcion_almacen"] = $request["localizacion_descripcion_almacen"];
            $data["vigencia_calibracion_tanque"] = $request["vigencia_calibracion_tanque"];
            $data["capacidad_almacen"] = $request["capacidad_almacen"];
            $data["capacidad_operativa"] = $request["capacidad_operativa"];
            $data["capacidad_util"] = $request["capacidad_util"];
            $data["capacidad_fondaje"] = $request["capacidad_fondaje"];
            $data["volumen_minimo_operacion"] = $request["volumen_minimo_operacion"];
            $data["estado_tanque"] = $request["estado_tanque"];

            $res = Almacen::create($data);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Almacen $almacen)
    {
        try {
            $data = Almacen::find($request->id);
            return  response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Almacen $almacen)
    {
        try {
            $data["clave_almacen"] = $request["clave_almacen"];
            $data["localizacion_descripcion_almacen"] = $request["localizacion_descripcion_almacen"];
            $data["vigencia_calibracion_tanque"] = $request["vigencia_calibracion_tanque"];
            $data["capacidad_almacen"] = $request["capacidad_almacen"];
            $data["capacidad_operativa"] = $request["capacidad_operativa"];
            $data["capacidad_util"] = $request["capacidad_util"];
            $data["capacidad_fondaje"] = $request["capacidad_fondaje"];
            $data["volumen_minimo_operacion"] = $request["volumen_minimo_operacion"];
            $data["estado_tanque"] = $request["estado_tanque"];

            Almacen::find($request->id)->update($data);
            $res = Almacen::find($request->id);
            return  response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Almacen $almacen)
    {
        try {
            $res = Almacen::find($request->id)->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }
}
