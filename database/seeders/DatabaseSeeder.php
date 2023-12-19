<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; // Import the Category model
use App\Models\Resource; // Import the Resource model

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'PHP']);
        Category::create(['name' => 'JavaScript']);
        Category::create(['name' => 'CSS']);
        Category::create(['name' => 'HTML']);

        foreach (Category::all() as $category) {
            Resource::factory()->count(5)->create([
                'category_id' => $category->id,
            ]);
        }
    }
}
