<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\Positions::factory()->count(50)->create();
         \App\Models\Employees::factory()->count(100)->create();
    }
}
