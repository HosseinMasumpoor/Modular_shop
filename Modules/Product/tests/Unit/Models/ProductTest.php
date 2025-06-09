<?php

namespace Modules\Product\tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Category\Models\Category;
use Modules\Product\Models\Brand;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductAttribute;
use Modules\Product\Models\ProductImage;
use Modules\Product\Models\ProductVariant;
use Modules\Product\Models\ProductVariantType;
use Tests\TestCase;
use Tests\Traits\Models\TestFillableAttributes;
use Tests\Traits\Models\TestModelRelations;

class ProductTest extends TestCase
{
    use RefreshDatabase, TestModelRelations, TestFillableAttributes;

    protected function getModelClass(): string
    {
        return Product::class;
    }

    public function test_fillable_fields(): void
    {
        $unauthorizedData = [
            'unauthorized_data' => 'some value'
        ];

        $this->assertOnlyFillablePersisted($unauthorizedData);
    }

    public function test_it_belongs_to_a_category(): void
    {
        $this->assertBelongsToRelation('category', Category::class, 'category_id');
    }

    public function test_it_belongs_to_a_variation_type(): void
    {
        $this->assertBelongsToRelation('variantType', ProductVariantType::class, 'variant_type_id');
    }

    public function test_it_has_many_attributes(): void
    {
        $this->assertHasManyRelation('attributes', ProductAttribute::class, 'product_id');
    }

    public function test_it_has_many_variants(): void
    {
        $this->assertHasManyRelation('variants', ProductVariant::class, 'product_id');
    }

    public function test_it_has_many_images(): void
    {
        $this->assertHasManyRelation('images', ProductImage::class, 'product_id');
    }

    public function test_it_belongs_to_a_brand(): void
    {
        $this->assertBelongsToRelation('brand', Brand::class, 'brand_id');
    }
}
