<?php

namespace Database\Seeders;

use App\Models\Comprobante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comprobante::insert([
            [
                'nombre' => 'BOLETA',
                'serie_text' => 'BE'
            ],
            [
                'nombre' => 'FACTURA',
                'serie_text' => 'FE'
            ]
        ]);
    }
}