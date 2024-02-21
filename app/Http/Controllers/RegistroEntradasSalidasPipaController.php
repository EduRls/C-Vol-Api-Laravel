<?php

namespace App\Http\Controllers;

use App\Models\RegistroEntradasSalidasPipa;
use Illuminate\Http\Request;

class RegistroEntradasSalidasPipaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = RegistroEntradasSalidasPipa::get();
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
            $data["inventario_inical"] = $request["inventario_inical"];
            $data["compra"] = $request["compra"];
            $data["venta"] = $request["venta"];
            $data["inventario_final"] = $request["inventario_final"];

            $res = RegistroEntradasSalidas::create($data);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(RegistroEntradasSalidasPipa $registroEntradasSalidasPipa)
    {
        try {
            $data = RegistroEntradasSalidasPipa::find($id);
            return  response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegistroEntradasSalidasPipa $registroEntradasSalidasPipa)
    {
        try {
            $data["inventario_inical"] = $request["inventario_inical"];
            $data["compra"] = $request["compra"];
            $data["venta"] = $request["venta"];
            $data["inventario_final"] = $request["inventario_final"];

            RegistroEntradasSalidasPipa::find($id)->update($data);
            $res = RegistroEntradasSalidasPipa::find($id);
            return  response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegistroEntradasSalidasPipa $registroEntradasSalidasPipa)
    {
        try {
            $res = RegistroEntradasSalidasPipa::find($id)->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }
}
