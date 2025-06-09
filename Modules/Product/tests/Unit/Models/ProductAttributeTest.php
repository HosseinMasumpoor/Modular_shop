<?php

namespace Modules\Product\tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductAttribute;
use Tests\TestCase;
use Tests\Traits\Models\TestFillableAttributes;
use Tests\Traits\Models\TestModelRelations;

class ProductAttributeTest extends TestCase
{
    use RefreshDatabase, TestModelRelations, TestFillableAttributes;

    protected function getModelClass(): string
    {
        return ProductAttribute::class;
    }

    public function test_fillable_fields(): void
    {
        $unauthorizedData = [
            'unauthorized_data' => 'some value'
        ];

        $this->assertOnlyFillablePersisted($unauthorizedData);
    }

    public function test_it_belongs_to_product(): void
    {
        $this->assertBelongsToRelation('product', Product::class, 'product_id');
    }

//    public function test_it_has_many_variant_type_values(): void
//    {
//        $this->assertHasManyRelation('values', ProductVariantTypeValue::class, 'variant_type_id');
//    }

}
