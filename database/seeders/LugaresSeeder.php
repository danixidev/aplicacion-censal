<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LugaresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 10; $i++) {
            DB::table('comunidades')->insert([
                'nombre_comunidad' => Str::random(10),
            ]);
            DB::table('provincias')->insert([
                'nombre_provincia' => Str::random(10),
                'comunidad_id' => $i,
            ]);
            DB::table('localidades')->insert([
                'nombre_localidad' => Str::random(10),
                'provincia_id' => $i,
            ]);
            DB::table('cps')->insert([
                'cp' => rand(01000, 52003),
                'localidad_id' => $i,
            ]);
        }
    }
}
