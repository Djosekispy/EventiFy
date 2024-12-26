<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_title' => 'Festas', 'created_at' => now(), 'updated_at' => now()],
            ['category_title' => 'Conferência', 'created_at' => now(), 'updated_at' => now()],
            ['category_title' => 'Workshop', 'created_at' => now(), 'updated_at' => now()],
            ['category_title' => 'Religião', 'created_at' => now(), 'updated_at' => now()],
            ['category_title' => 'Desporto', 'created_at' => now(), 'updated_at' => now()],
            ['category_title' => 'Outros', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert($categories);
    }
}
