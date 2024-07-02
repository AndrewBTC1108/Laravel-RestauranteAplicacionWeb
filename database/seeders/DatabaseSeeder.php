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
        //Aqui mandamos agregar el seeder
        $this->call(CategoriaSeeder::class);
        $this->call(ProductoSeeder::class);
    }
}
