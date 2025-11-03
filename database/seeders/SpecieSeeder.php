<?php

namespace Database\Seeders;

use App\Models\Specie;
use Illuminate\Database\Seeder;

class SpecieSeeder extends Seeder
{
    public function run(): void
    {
        Specie::query()->delete();

        Specie::create(['name' => 'Cão']);
        Specie::create(['name' => 'Gato']);
        Specie::create(['name' => 'Coelho']);
    }
}