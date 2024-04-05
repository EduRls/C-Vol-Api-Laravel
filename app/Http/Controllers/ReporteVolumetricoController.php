<?php

namespace App\Http\Controllers;

use App\Models\ReporteVolumetrico;
use Illuminate\Http\Request;

class ReporteVolumetricoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idPlanta)
    {
        try {
            $data = ReporteVolumetrico::where('id_planta', $idPlanta)->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([ "error" => $th->getMessage() ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data['id_planta'] = $request['id_planta'];
            $data['reporte'] = $request['reporte'];

            $res = ReporteVolumetrico::create($data);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return  response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ReporteVolumetrico $reporteVolumetrico)
    {
        try {
            $data = ReporteVolumetrico::find($id);
            return  response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReporteVolumetrico $reporteVolumetrico)
    {
        try {
            $data['id_planta'] = $request['id_planta'];
            $data['reporte'] = $request['reporte'];

            ReporteVolumetrico::find($id)->update($data);
            $res = ReporteVolumetrico::find($id);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReporteVolumetrico $reporteVolumetrico)
    {
        try {
            $res = ReporteVolumetrico::find($id)->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()-json(['error' => $th->getMessage()], 500);
        }
    }
}
