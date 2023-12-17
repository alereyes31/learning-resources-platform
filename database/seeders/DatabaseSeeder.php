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
        $categories = Category::factory()->count(5)->create();

        foreach ($categories as $category) {
            Resource::factory()->count(5)->create([
                'category_id' => $category->id,
            ]);
        }
    }
}
