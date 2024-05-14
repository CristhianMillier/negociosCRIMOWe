<?php

namespace Database\Seeders;

use App\Models\Almacene;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Almacene::insert([
            [
                'direccion' => 'PROL. GARCILAZO DE LA VEGA N° 1296',
                'distrito' => 'JAÉN',
                'provincia' => 'JAÉN',
                'departamento' => 'CAJAMARCA',
                'serie_comprobante' => '001'
            ]
        ]);
    }
}