<?php

namespace App\Http\Controllers;

use App\Models\EventoAlmacen;
use Illuminate\Http\Request;

class EventoAlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idAlmacen)
    {
        try {
            $eventos = EventoAlmacen::with('almacen')
                ->orderBy('fecha_inicio_evento', 'desc')
                ->get();

    return response()->json($eventos, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 501);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data["id_almacen"] = $request["id_almacen"];
            $data["tipo_evento"] = $request["tipo_evento"];
            $data["volumen_inicial"] = $request["volumen_inicial"];
            $data["volumen_movido"] = $request["volumen_movido"];
            $data["volumen_final"] = $request["volumen_final"];
            $data["fecha_inicio_evento"] = $request["fecha_inicio_evento"];
            $data["fecha_fin_evento"] = $request["fecha_fin_evento"];
            $data["temperatura"] = $request["temperatura"];
            $data["presion_absoluta"] = $request["presion_absoluta"];
            $data["observaciones"] = $request["observaciones"];

            $res = EventoAlmacen::create($data);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, EventoAlmacen $eventoAlmacen)
    {
        try {
            $data = EventoAlmacen::find($request->id);
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventoAlmacen $eventoAlmacen)
    {
        try {
            $data["id_almacen"] = $request["id_almacen"];
            $data["tipo_evento"] = $request["tipo_evento"];
            $data["volumen_inicial"] = $request["volumen_inicial"];
            $data["volumen_movido"] = $request["volumen_movido"];
            $data["volumen_final"] = $request["volumen_final"];
            $data["fecha_inicio_evento"] = $request["fecha_inicio_evento"];
            $data["fecha_fin_evento"] = $request["fecha_fin_evento"];
            $data["temperatura"] = $request["temperatura"];
            $data["presion_absoluta"] = $request["presion_absoluta"];
            $data["observaciones"] = $request["observaciones"];

            EventoAlmacen::find($request->id)->update($data);
            $res = EventoAlmacen::find($request->id);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, EventoAlmacen $eventoAlmacen)
    {
        try {
            $res = EventoAlmacen::find($request->id)->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
