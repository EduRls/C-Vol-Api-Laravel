<?php

namespace App\Http\Controllers;

use App\Models\RolesUsuarios;
use Illuminate\Http\Request;

class RolesUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = RolesUsuarios::get();
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
            $data['id_planta'] = $request['id_planta'];
            $data["rol"] = $request["rol"];

            $res = RolesUsuarios::create($data);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RolesUsuarios $rolesUsuarios)
    {
        try {
            $data = RolesUsuarios::find($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response() -> json(['error'=>$th->getMessage()],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RolesUsuarios $rolesUsuarios)
    {
        try {
            $data["rol"] = $request["rol"];

            RolesUsuarios::find($request->id)->update($data);
            $res = RolesUsuarios::find($request->id);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage() ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, RolesUsuarios $rolesUsuarios)
    {
        try {
            $res = RolesUsuarios::find($request->id)->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
}
