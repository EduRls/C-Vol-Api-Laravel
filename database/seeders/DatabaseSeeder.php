<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Poblar la tabla de roles
        DB::table('roles_usuarios')->insert([
            ['rol' => 'Admin'],
            ['rol' => 'Capturista'],
            ['rol' => 'Analista'],
        ]);

        DB::table('planta_gas')->insert([
            [
                'nombre_planta' => "Gas Butano Zacatecas S.A de C.V",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        //\App\Models\User::factory(1)->create();

         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'id_planta' => 1,
             'id_rol_usuario' => 1,
             'email' => 'test@example.com',
             'password' => 'test12345'
         ]);

         \App\Models\User::factory()->create([
            'name' => 'Tarjetita ESP8266',
            'id_planta' => 1,
            'id_rol_usuario' => 2,
            'email' => 'esp8266@gasbutano.com',
            'password' => 'esp8266butano'
        ]);

        

        DB::table('informacion_general_reporte')->insert([
            [
                'id_planta' => 1,
                'rfc_contribuyente' => 'XYZJ880326XXX',
                'rfc_representante_legal' => 'ABCD123456XXX',
                'rfc_proveedor' => 'PROV730123XXX',
                'tipo_caracter' => 'Tipo 1',
                'rfc_proveedores' => json_encode(["XYZJ880326XXX", "ABCD123456XXX", "PROV730123XXX"]),
                'modalidad_permiso' => 'Modalidad 1',
                'numero_permiso' => 'Permiso123',
                'numero_contrato_asignacion' => 'Contrato123',
                'instalacion_almacen_gas' => 'Instalación 1',
                'clave_instalacion' => 'Clave1',
                'descripcion_instalacion' => 'Descripción de la instalación 1',
                'geolocalizacion_latitud' => 19.432608,
                'geolocalizacion_longitud' => -99.133209,
                'numero_pozos' => 5,
                'numero_tanques' => 10,
                'numero_ductos_entrada_salida' => 2,
                'numero_ductos_transporte' => 3,
                'numero_dispensarios' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Puedes añadir más registros aquí si lo necesitas
        ]);

        

        
    }
}
