<?php

namespace App\Http\Controllers;

use App\Models\InformacionUsuarios;
use Illuminate\Http\Request;

class InformacionUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = InformacionUsuarios::get();
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
            $data['nombre_usuario'] = $request['nombre_usuario'];
            $data['apellido_paterno'] = $request['apellido_paterno'];
            $data['apellido_materno'] = $request['apellido_materno'];

            $res =  InformacionUsuarios::create($data);
            return  response()->json(['message'=>'Registro exitoso!'],201);
        } catch (\Throwable $th) {
            return response() -> json( ['error'=>$th->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InformacionUsuarios $informacionUsuarios)
    {
        try {
            $data = InformacionUsuarios::find($id);
            return  response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformacionUsuarios $informacionUsuarios)
    {
        try {
            $data['nombre_usuario'] = $request['nombre_usuario'];
            $data['apellido_paterno'] = $request['apellido_paterno'];
            $data['apellido_materno'] = $request['apellido_materno'];

            InformacionUsuarios::find($id)->update($data);
            $res = InformacionUsuarios::find($id);
            return response()->json( $res , 200);
        } catch (\Throwable $th) {
            return response() -> json( ['error'=>$th->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InformacionUsuarios $informacionUsuarios)
    {
        try {
            $res = InformacionUsuarios::find($id)->delete();
            return response()->json([ "deleted" => $res ], 200);
        } catch (\Throwable $th) {
            return  response()->json(['error'=>$th->getMessage()],500);
        }
    }
}
