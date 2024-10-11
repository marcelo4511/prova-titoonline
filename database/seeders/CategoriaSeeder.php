<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::updateOrCreate(
            ['id' => 1],
            ['id' => 1, 'nome' => 'TVs']
        );

        Categoria::updateOrCreate(
            ['id' => 2],
            ['id' => 2, 'nome' => 'SmartPhones']
        );
    }
}
