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

class BrandTest extends TestCase
{
    use RefreshDatabase, TestModelRelations, TestFillableAttributes;

    protected function getModelClass(): string
    {
        return Brand::class;
    }

    public function test_fillable_fields(): void
    {
        $unauthorizedData = [
            'unauthorized_data' => 'some value'
        ];

        $this->assertOnlyFillablePersisted($unauthorizedData);
    }

    public function test_it_has_many_products(): void
    {
        $this->assertHasManyRelation('products', Product::class, 'brand_id');
    }
}

