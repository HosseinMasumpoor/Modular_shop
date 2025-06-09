<?php

namespace Modules\Product\tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariant;
use Modules\Product\Models\ProductVariantTypeValue;
use Tests\TestCase;
use Tests\Traits\Models\TestFillableAttributes;
use Tests\Traits\Models\TestModelRelations;

class ProductVariantTest extends TestCase
{
    use RefreshDatabase, TestModelRelations, TestFillableAttributes;

    protected function getModelClass(): string
    {
        return ProductVariant::class;
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
        $this->assertBelongsToRelation('product', Product::class, 'product_id');
    }

    public function test_it_belongs_to_a_variant_type(): void
    {
        $this->assertBelongsToRelation('variant', ProductVariantTypeValue::class, 'variant_type_value_id');
    }
}
