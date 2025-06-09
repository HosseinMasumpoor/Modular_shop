<?php

namespace Modules\Product\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariantType;
use Modules\Product\Models\ProductVariantTypeValue;

class ProductVariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Product\Models\ProductVariant::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'variant_type_value_id' => ProductVariantTypeValue::factory(),
            'price' => $this->faker->randomFloat(1, 1, 1000),
            'quantity' => $this->faker->randomNumber(4),
            'sku' => $this->faker->uuid(),
        ];
    }
}

