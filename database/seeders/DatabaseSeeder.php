<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(1)->create();

         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
             'password' => 'test12345'
         ]);

         \App\Models\User::factory()->create([
            'name' => 'Tarjetita ESP8266',
            'email' => 'esp8266@gasbutano.com',
            'password' => 'esp8266butano'
        ]);
    }
}
