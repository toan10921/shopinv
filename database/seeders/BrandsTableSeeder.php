<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\Brand::factory()->create([
            'name' => 'Apple'
        ]);
        \App\Models\Brand::factory()->create([
            'name' => 'Dell'
        ]);
    }
}
