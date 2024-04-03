<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformacionGeneralReporte;

class InformacionGeneralReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = InformacionGeneralReporte::get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->only([
                'rfc_contribuyente',
                'rfc_representante_legal',
                'rfc_proveedor',
                'tipo_caracter',
                'modalidad_permiso',
                'numero_permiso',
                'numero_contrato_asignacion',
                'instalacion_almacen_gas',
                'clave_instalacion',
                'descripcion_instalacion',
                'geolocalizacion_latitud',
                'geolocalizacion_longitud',
                'numero_pozos',
                'numero_tanques',
                'numero_ductos_entrada_salida',
                'numero_ductos_transporte',
                'numero_dispensarios',
            ]);

            $res = InformacionGeneralReporte::create($data);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        try {
            $data = InformacionGeneralReporte::find($id);
            if (!$data) {
                return response()->json(['error' => 'Resource not found.'], 404);
            }
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->only([
                'rfc_contribuyente',
                'rfc_representante_legal',
                'rfc_proveedor',
                'tipo_caracter',
                'modalidad_permiso',
                'numero_permiso',
                'numero_contrato_asignacion',
                'instalacion_almacen_gas',
                'clave_instalacion',
                'descripcion_instalacion',
                'geolocalizacion_latitud',
                'geolocalizacion_longitud',
                'numero_pozos',
                'numero_tanques',
                'numero_ductos_entrada_salida',
                'numero_ductos_transporte',
                'numero_dispensarios',
            ]);

            $model = InformacionGeneralReporte::find($id);
            if (!$model) {
                return response()->json(['error' => 'Resource not found.'], 404);
            }

            $model->update($data);
            return response()->json($model, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $model = InformacionGeneralReporte::find($id);
            if (!$model) {
                return response()->json(['error' => 'Resource not found.'], 404);
            }
            
            $res = $model->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
