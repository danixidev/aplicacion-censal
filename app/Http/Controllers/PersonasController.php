<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;

class PersonasController extends Controller
{
    public function crear (Request $req) {
        $datos = $req->getContent();

        // VALIDAR EL JSON
        $datos = json_decode($datos);

        // VALIDAR LOS DATOS
        $persona = new Persona();

        $persona->nombre = $datos->nombre;
        $persona->primer_apellido = $datos->primer_apellido;
        $persona->segundo_apellido = $datos->segundo_apellido;

        try {
            $persona->save();
            $respuesta['msg'] = "Persona guardada con id ".$persona->id;
        } catch (\Throwable $th) {
            $respuesta['msg'] = $th->getMessage();
            $respuesta['status'] = 0;
        }

        return response()->json($respuesta);
    }
    public function borrar (Request $req) {
        $respuesta = ["status" => 1, "msg" => ""];

        // Buscar a la persona a borrar
        $persona = Persona::find($id);

        if($persona) {
            try {
                $persona->delete();
                $respuesta['msg'] = "Persona borrada";
            } catch (\Throwable $th) {
                $respuesta['msg'] = $th->getMessage();
                $respuesta['status'] = 0;
            }
        }


        return response()->json($respuesta);
    }
    public function modificar (Request $req) {

    }
    public function listar (Request $req) {
        
    }
    public function ver (Request $req) {
        
    }
}
