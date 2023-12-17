<?php

namespace Database\Factories;

use App\Models\Resource;
use App\Models\Category; 
use App\Models\User; 

use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    protected $model = Resource::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'category_id' => Category::factory(),
            'link' => $this->faker->url,
            'description' => $this->faker->paragraph,
            'creator_id' => User::factory(),
            // Otros campos si los tienes
        ];
    }
}
