<?php

namespace Database\Seeders;

use App\Models\Tarif;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tarif::factory()->create([
            'jenis_plg' => 'R1',
            'biaya_beban' => 48672,
            'tarif_kwh' => 1352,
            'batas_daya' => '900VA',
        ]);

        Tarif::factory()->create([
            'jenis_plg' => 'R2',
            'biaya_beban' => 237934.20,
            'tarif_kwh' => 1669.53,
            'batas_daya' => '3500VA',
        ]);

        Tarif::factory()->create([
            'jenis_plg' => 'R3',
            'biaya_beban' => 400687.20,
            'tarif_kwh' => 1669.53,
            'batas_daya' => '6000VA',
        ]);
    }
}
