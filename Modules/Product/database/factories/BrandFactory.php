<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Product\Models\Brand::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'logo' => $this->faker->imageUrl(),
            'meta_title' => $this->faker->name(),
            'meta_description' => $this->faker->text(),
            'meta_keywords' => $this->faker->text(),
        ];
    }
}

