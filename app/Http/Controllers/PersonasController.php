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
            $respuesta['msg'] = "Se ha producido un error:".$th->getMessage();
            $respuesta['status'] = 0;
        }

        return response()->json($respuesta);
    }

    public function borrar ($id) {
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

    public function editar (Request $req, $id) {
        $respuesta = ["status" => 1, "msg" => ""];

        $datos = $req->getContent();
        // VALIDAR EL JSON
        $datos = json_decode($datos);

        // Buscar a la persona a editar
        $persona = Persona::find($id);

        if ($persona) {
            if(isset($datos->nombre)) {
                $persona->nombre = $datos->nombre;
            }
            if(isset($datos->primer_apellido)) {
                $persona->primer_apellido = $datos->primer_apellido;
            }
            if(isset($datos->segundo_apellido)) {
                $persona->segundo_apellido = $datos->segundo_apellido;
            }
        }

        // Escribir en la base de datos
        try {
            $persona->save();
            $respuesta['msg'] = "Persona actualizada";
        } catch (\Throwable $th) {
            $respuesta['msg'] = "Se ha producido un error:".$th->getMessage();
            $respuesta['status'] = 0;
        }

        return response()->json($respuesta);
    }

    public function listar () {
        $respuesta = ["status" => 1, "msg" => ""];

        try {
            $respuesta['datos'] = Persona::all();
        } catch (\Throwable $th) {
            $respuesta['msg'] = "Se ha producido un error:".$th->getMessage();
            $respuesta['status'] = 0;
        }

        return response()->json($respuesta);
    }

    public function ver ($id) {
        $respuesta = ["status" => 1, "msg" => ""];

        // Buscar a la persona a editar
        $persona = Persona::find($id);

        // Escribir en la base de datos
        try {
            $persona = Persona::find($id);
            if($persona) {
                $persona->makeVisible('primer_apellido');
                $respuesta['datos'] = $persona;
            } else {
                $respuesta['status'] = 0;
                $respuesta['msg'] = "Persona no encontrada";
            }
        } catch (\Throwable $th) {
            $respuesta['msg'] = "Se ha producido un error:".$th->getMessage();
            $respuesta['status'] = 0;
        }

        return response()->json($respuesta);
    }
}
