<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;


use App\Models\Domicilio;
use App\Models\Cp;
use App\Models\Localidade;
use App\Models\Provincia;
use App\Models\Comunidade;
use Faker\Provider\ar_JO\Person;

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
        $persona->domicilio = $datos->domicilio;
        $persona->nacimiento = $datos->nacimiento;

        if(!isset($datos->padre)) {
            $persona->padre = NULL;
        } else {
            $persona->padre = $datos->padre;
        }
        if(!isset($datos->madre)) {
            $persona->madre = NULL;
        } else {
            $persona->madre = $datos->madre;
        }

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
            if(isset($datos->domicilio)) {
                $persona->domicilio = $datos->domicilio;
            }
            if(isset($datos->nacimiento)) {
                $persona->nacimiento = $datos->nacimiento;
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

        try {
            $persona = Persona::find($id);
            if($persona) {
                // $persona->father;

                $persona->makeVisible(['domicilio','padre','madre','created_at','updated_at']);
                $respuesta['datos'] = $persona;
                $respuesta['padres'] = $this->buscarPadres($id);
                $respuesta['hijos'] = $this->buscarHijos($id);
                $respuesta['hermanos'] = $this->buscarHermanos($id);
                $respuesta['domicilio'] = $this->buscarDatosDireccion($id);
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

    /**
     * Recibe la condicion a cumplir y la fecha     (ejemplo: /<>/2002-07-03)
     * Condiciones:
     *  - Distinto: <> o !=
     *  - Igual: =
     *  - Mayor: >
     *  - Menor: <
     */
    public function filtrarEdad($condicion, $nacimiento) {
        $respuesta = ["status" => 1, "msg" => ""];

        try {
            $respuesta['datos'] = Persona::where('nacimiento',$condicion , $nacimiento)->orderBy('nacimiento', 'asc')->get();
        } catch (\Throwable $th) {
            $respuesta['msg'] = "Se ha producido un error:".$th->getMessage();
            $respuesta['status'] = 0;
        }

        return response()->json($respuesta);
    }

    /**
     * Recibe la condicion a cumplir y la provincia     (ejemplo: /<>/2002-07-03)
     * Condiciones:
     *  - Distinto: <> o !=
     *  - Igual: =
     *  - Mayor: >
     *  - Menor: <
     */
    public function filtrarProvincia($condicion, $provincia) {
        $respuesta = ["status" => 1, "msg" => ""];

        try {
            $provincia = Provincia::where('nombre_provincia', $condicion, $provincia)->value('nombre_provincia');


            $provincia_id = Provincia::where('nombre_provincia', $provincia)->value('id');
            $localidad_id = Localidade::where('provincia_id', $provincia_id)->value('id');
            $cp = Cp::where('localidad_id', $localidad_id)->value('cp');
            $domicilio_id = Domicilio::where('codigo_postal', $cp)->value('id');

            $persona = Persona::where('domicilio', $domicilio_id)->get();

            $respuesta['datos'] = $persona;
        } catch (\Throwable $th) {
            $respuesta['msg'] = "Se ha producido un error:".$th->getMessage();
            $respuesta['status'] = 0;
        }

        return response()->json($respuesta);
    }

    private function buscarPadres($id) {
        $padre_id = Persona::where('id', $id)->value('padre');
        $padre = Persona::where('id', $padre_id)->get();

        $madre_id = Persona::where('id', $id)->value('madre');
        $madre = Persona::where('id', $madre_id)->get();

        $padres['padre'] = $padre;
        $padres['madre'] = $madre;

        return $padres;
    }

    private function buscarHijos($id) {
        $padres_id = Persona::where('id', $id)->value('id');
        $hijos = Persona::where('padre', $padres_id)->orWhere('madre', $padres_id)->whereNotNull('padre')->whereNotNull('madre')->get();

        return $hijos;
    }

    private function buscarHermanos($id) {
        $id = Persona::where('id', $id)->value('id');

        $padre_id = Persona::where('id', $id)->value('padre');
        $madre_id = Persona::where('id', $id)->value('madre');
        $hermanos = Persona::where('padre', $padre_id)->where('madre', $madre_id)->where('id', '<>', $id)->get();     //Ocultar a uno mismo

        return $hermanos;
    }

    private function buscarDatosDireccion($id) {
        $domicilio_id = Persona::where('id', $id)->value('domicilio');
        $domicilio = Domicilio::find($domicilio_id);

        // $calle = Domicilio::where('id', $domicilio_id)->value('calle');
        $calle = $domicilio->calle;
        $numero = Domicilio::where('id', $domicilio_id)->value('numero');

        $codigo_postal = $domicilio['codigo_postal'];

        // Tabla 'cps'
        $localidad_id = Cp::where('cp', $codigo_postal)->value('localidad_id');     //Id de la localidad a la que pertenece
        $localidad = Localidade::where('id', $localidad_id)->value('nombre_localidad');     //Nombre de la localidad a la que pertenece

        // Tabla 'localidades'
        $provincia_id = Localidade::where('nombre_localidad', $localidad)->value('provincia_id');       //Id de la provincia a la que pertenece
        $provincia = Provincia::where('id', $provincia_id)->value('nombre_provincia');      //Nombre de la provincia a la que pertenece

        // Tabla 'provincias'
        $comunidad_id = Provincia::where('nombre_provincia', $provincia)->value('comunidad_id');        //Id de la comunidad a la que pertenece
        $comunidad = Comunidade::where('id', $comunidad_id)->value('nombre_comunidad');     //Nombre de la comunidad a la que pertenece

        $datos_domicilio = [
            "calle" => $calle,
            "numero" => $numero,
            "codigo_postal" => $codigo_postal,      //Valor opcional, añadido para que sea mas visual (es redundante)
            "localidad" => $localidad,
            "provincia" => $provincia,
            "comunidad" => $comunidad
        ];

        return $datos_domicilio;
    }
}
