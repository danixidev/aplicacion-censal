<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domicilio;
use App\Models\Cp;
use App\Models\Localidade;
use League\Flysystem\Adapter\Local;

class DomiciliosController extends Controller
{
    public function crear (Request $req) {
        $datos = $req->getContent();

        // VALIDAR EL JSON
        $datos = json_decode($datos);

        // VALIDAR LOS DATOS
        $domicilio = new Domicilio();

        $domicilio->calle = $datos->calle;
        $domicilio->numero = $datos->numero;
        $domicilio->codigo_postal = $datos->codigo_postal;


        try {
            $domicilio->save();
            $respuesta['msg'] = "Domicilio guardado con id ".$domicilio->id;
        } catch (\Throwable $th) {
            $respuesta['msg'] = "Se ha producido un error:".$th->getMessage();
            $respuesta['status'] = 0;
        }

        return response()->json($respuesta);
    }

    public function borrar ($id) {
        $respuesta = ["status" => 1, "msg" => ""];

        // Buscar el domicilio a borrar
        $domicilio = Domicilio::find($id);

        if($domicilio) {
            try {
                $domicilio->delete();
                $respuesta['msg'] = "Domicilio borrado";
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

        // Buscar el domicilio a editar
        $domicilio = Domicilio::find($id);

        if ($domicilio) {
            if(isset($datos->calle)) {
                $domicilio->calle = $datos->calle;
            }
            if(isset($datos->numero)) {
                $domicilio->numero = $datos->numero;
            }
            if(isset($datos->codigo_postal)) {
                $domicilio->codigo_postal = $datos->codigo_postal;
            }
        }

        // Escribir en la base de datos
        try {
            $domicilio->save();
            $respuesta['msg'] = "Domicilio actualizado";
        } catch (\Throwable $th) {
            $respuesta['msg'] = "Se ha producido un error:".$th->getMessage();
            $respuesta['status'] = 0;
        }

        return response()->json($respuesta);
    }

    public function ver ($id) {
        $respuesta = ["status" => 1, "msg" => ""];

        try {
            $domicilio = Domicilio::find($id);

            $codigo_postal = $domicilio['codigo_postal'];


            $localidad_id = Cp::select('localidad_id')->where('cp', $codigo_postal)->get()->toArray();
            $localidad = Localidade::select('nombre_localidad')->where('id', $localidad_id)->get();


            $datos_domicilio = [
                "codigo_postal" => $codigo_postal,
                "localidad" => $localidad
            ];
/*
            $codigo_postal
            $localidad
            $provincia
            $comunidad
*/

            if($domicilio) {
                $respuesta['datos'] = $domicilio;
                $respuesta['domicilio'] = $datos_domicilio;
            } else {
                $respuesta['status'] = 0;
                $respuesta['msg'] = "Domicilio no encontrado";
            }
        } catch (\Throwable $th) {
            $respuesta['msg'] = "Se ha producido un error:".$th->getMessage();
            $respuesta['status'] = 0;
        }

        return response()->json($respuesta);
    }
}
