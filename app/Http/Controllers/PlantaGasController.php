<?php

namespace App\Http\Controllers;

use App\Models\PlantaGas;
use Illuminate\Http\Request;

class PlantaGasController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = PlantaGas::get();
            return  response()->json($data);
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
            $data["nombre_planta"] = $request["nombre_planta"];

            $res = PlantaGas::create($data);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PlantaGas $plantaGas)
    {
        try {
            $data = PlantaGas::find($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response() -> json(['error'=>$th->getMessage()],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlantaGas $plantaGas)
    {
        try {
            $data["nombre_planta"] = $request["nombre_planta"];

            PlantaGas::find($request->id)->update($data);
            $res = PlantaGas::find($request->id);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage() ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, PlantaGas $plantaGas)
    {
        try {
            $res = PlantaGas::find($request->id)->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
}
