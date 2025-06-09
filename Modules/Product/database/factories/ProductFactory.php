<?php

namespace Modules\Product\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Category\Models\Category;
use Modules\Product\Enums\ProductStatus;
use Modules\Product\Models\Brand;
use Modules\Product\Models\ProductVariantType;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Product\Models\Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'slug' => $this->faker->slug(),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'variant_type_id' => ProductVariantType::factory(),
            'status' => $this->faker->randomElement(ProductStatus::getValues()),
            'meta_title' => $this->faker->name(),
            'meta_description' => $this->faker->text(),
            'meta_keywords' => $this->faker->text(),
        ];
    }
}

