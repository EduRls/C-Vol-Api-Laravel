<?php

namespace App\Http\Controllers;

use App\Models\RegistroLlenadoAlmacen;
use Illuminate\Http\Request;

class RegistroLlenadoAlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idPlanta)
    {
        try {
            $data = RegistroLlenadoAlmacen::with('almacen')->where('id_planta', $idPlanta)->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage() ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data['id_planta'] = $request['id_planta'];
            $data["id_almacen"] = $request["id_almacen"];
            $data["cantidad_inical"] = $request["cantidad_inical"];
            $data["cantidad_final"] = $request["cantidad_final"];
            $data["fecha_llenado"] = $request["fecha_llenado"];

            $res = RegistroLlenadoAlmacen::create($data);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, RegistroLlenadoAlmacen $registroLlenadoAlmacen)
    {
        try {
            $data = RegistroLlenadoAlmacen::find($request->id);
            return  response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegistroLlenadoAlmacen $registroLlenadoAlmacen)
    {
        try {
            $data["cantidad_inical"] = $request["cantidad_inical"];
            $data["cantidad_final"] = $request["cantidad_final"];
            $data["fecha_llenado"] = $request["fecha_llenado"];

            RegistroLlenadoAlmacen::find($request->id)->update($data);
            $res = RegistroLlenadoAlmacen::find($request->id);
            return  response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, RegistroLlenadoAlmacen $registroLlenadoAlmacen)
    {
        try {
            $res = RegistroLlenadoAlmacen::find($request->id)->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }
}
