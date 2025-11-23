<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vaccine;
use Illuminate\Support\Facades\DB;

class VaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  Limpa a tabela antes de popular
        Vaccine::query()->delete();

        $vaccines = [
            // Vacinas para cães
            [
                'disease_name' => 'Parvovirose',
                'target_species' => 1,
                'doses' => 3,
                'duration' => 12,
            ],
            [
                'disease_name' => 'Leptospirose',
                'target_species' => 1,
                'doses' => 2,
                'duration' => 12,
            ],
            [
                'disease_name' => 'Gripe Canina',
                'target_species' => 1,
                'doses' => 2,
                'duration' => 12,
            ],

            // Vacinas para gatos
            [
                'disease_name' => 'Panleucopenia Felina',
                'target_species' => 2,
                'doses' => 3,
                'duration' => 12,
            ],
            [
                'disease_name' => 'Clamidiose Felina',
                'target_species' => 2,
                'doses' => 2,
                'duration' => 12,
            ],
            [
                'disease_name' => 'Leucemia Felina',
                'target_species' => 2,
                'doses' => 2,
                'duration' => 12,
            ],

            // Vacinas gerais
            [
                'disease_name' => 'Raiva',
                'target_species' => null,
                'doses' => 1,
                'duration' => 36,
            ],
        ];

        // Insere as vacinas na tabela
        foreach ($vaccines as $vaccine) {
            Vaccine::create($vaccine);
        }
    }
}
