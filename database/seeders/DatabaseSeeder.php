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
        $this->call(AlmacenSeeder::class);
        $this->call(ComprobanteSeeder::class);
        $this->call(TipoDocumentoSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(UserSeeder::class);
    }
}