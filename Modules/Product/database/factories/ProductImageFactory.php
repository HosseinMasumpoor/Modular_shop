<?php

namespace Modules\Product\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Category\Models\Category;
use Modules\Product\Enums\ProductImageType;
use Modules\Product\Enums\ProductStatus;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariantType;

class ProductImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Product\Models\ProductImage::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'image_path' => $this->faker->imageUrl(),
            'thumbnail_path' => $this->faker->imageUrl(),
            'type' => $this->faker->randomElement(ProductImageType::getValues()),
            'alt' => $this->faker->text(100),
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }
}

