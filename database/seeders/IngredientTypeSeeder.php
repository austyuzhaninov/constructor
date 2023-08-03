<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredient_type')->insert([
            ['title' => 'Тесто', 'code' => 'd'],
            ['title' => 'Сыр', 'code' => 'c'],
            ['title' => 'Начинка', 'code' => 'i'],
        ]);
    }
}
