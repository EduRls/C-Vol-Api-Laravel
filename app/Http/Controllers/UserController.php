<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idPlanta)
    {
        try {
            $data = User::with('planta')->with('rol')->where('id_planta', $idPlanta)->get();
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
            $data["name"] = $request["name"];
            $data["id_planta"] = $request["id_planta"];
            $data["id_rol_usuario"] = $request["id_rol_usuario"];
            $data["email"] = $request["email"];
            $data["password"] = $request["password"];

            $res = User::create($data);
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        try {
            $data = User::with('planta')->with('rol')->where('id',$request->idUsuario)->get();
            return  response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $data["name"] = $request["name"];
            $data["id_rol_usuario"] = $request["id_rol_usuario"];
            $data["email"] = $request["email"];
            if($request['password'] != ''){
                $data["password"] = $request["password"];
            }
            
            User::find($request->id)->update($data);
            $res = User::find($request->id);
            return  response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        try {
            $res = User::find($request->id)->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json([ 'error' => $th->getMessage()], 500);
        }
    }
}
