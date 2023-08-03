<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredient')->insert([
            ['type_id' => 1, 'title' => 'Тонкое тесто', 'price' => 100.00],
            ['type_id' => 1, 'title' => 'Пышное тесто', 'price' => 110.00],
            ['type_id' => 1, 'title' => 'Ржаное тесто', 'price' => 150.00],
            ['type_id' => 2, 'title' => 'Моцарелла', 'price' => 50.00],
            ['type_id' => 2, 'title' => 'Рикотта', 'price' => 70.00],
            ['type_id' => 3, 'title' => 'Колбаса', 'price' => 30.00],
            ['type_id' => 3, 'title' => 'Ветчина', 'price' => 35.00],
            ['type_id' => 3, 'title' => 'Грибы', 'price' => 50.00],
            ['type_id' => 3, 'title' => 'Томаты', 'price' => 10.00],
        ]);
    }
}
