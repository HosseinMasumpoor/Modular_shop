<?php

namespace Modules\Product\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\ProductVariantType;

class ProductVariantTypeValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Product\Models\ProductVariantTypeValue::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'variant_type_id' => ProductVariantType::factory(),
            'value' => $this->faker->word(),
            'slug' => $this->faker->slug(),
        ];
    }
}

