<?php

namespace Modules\Product\tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Models\ProductVariantType;
use Modules\Product\Models\ProductVariantTypeValue;
use Tests\TestCase;
use Tests\Traits\Models\TestFillableAttributes;
use Tests\Traits\Models\TestModelRelations;

class ProductVariantTypeValueTest extends TestCase
{
    use RefreshDatabase, TestModelRelations, TestFillableAttributes;

    protected function getModelClass(): string
    {
        return ProductVariantTypeValue::class;
    }

    public function test_fillable_fields(): void
    {
        $unauthorizedData = [
            'unauthorized_data' => 'some value'
        ];

        $this->assertOnlyFillablePersisted($unauthorizedData);
    }

    public function test_it_belongs_to_variant_type(): void
    {
        $this->assertBelongsToRelation('variantType', ProductVariantType::class, 'variant_type_id');
    }

//    public function test_it_has_many_variant_type_values(): void
//    {
//        $this->assertHasManyRelation('values', ProductVariantTypeValue::class, 'variant_type_id');
//    }

}
