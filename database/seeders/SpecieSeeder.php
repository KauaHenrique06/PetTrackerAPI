<?php

namespace Database\Seeders;

use App\Models\Specie;
use Illuminate\Database\Seeder;

class SpecieSeeder extends Seeder
{
    public function run(): void
    {
        Specie::query()->delete();

        Specie::create(['name' => 'dog']);
        Specie::create(['name' => 'cat']);
        Specie::create(['name' => 'other']);
    }
}