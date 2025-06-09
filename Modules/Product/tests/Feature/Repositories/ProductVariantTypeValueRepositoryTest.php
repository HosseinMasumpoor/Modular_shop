<?php

namespace Modules\Product\tests\Feature\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Models\ProductVariantType;
use Modules\Product\Models\ProductVariantTypeValue;
use Modules\Product\Repositories\ProductVariantTypeValueRepository;
use Tests\TestCase;
use Tests\Traits\Repositories\TestRepository;

class ProductVariantTypeValueRepositoryTest extends TestCase
{
    use RefreshDatabase, TestRepository;

    protected ProductVariantTypeValueRepository $repository;
    protected string $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ProductVariantTypeValueRepository();
        $this->model = ProductVariantTypeValue::class;
    }

    public function test_it_can_get_by_fields()
    {
        $filterData = ['value' => 'something'];
        $notMatchingData = ['value' => 'another thing'];
        $this->assertGetByFields($this->model, $this->repository, $filterData, $notMatchingData);
    }

    public function test_it_can_store_data()
    {
        $this->assertCreateNewItem($this->model, $this->repository);
    }

    public function test_it_can_find_by_field()
    {
        $this->assertFindByField($this->model, $this->repository, 'id');
    }

    public function test_it_can_update_data()
    {
        $this->assertUpdateItem($this->model, $this->repository);
    }

    public function test_it_can_delete_data()
    {
        $this->assertRemoveItem($this->model, $this->repository);
    }

    public function test_it_can_get_all_variant_type_values()
    {
        $variantType = ProductVariantType::factory()->create();
        $values = $this->model::factory(10)->create([
            'variant_type_id' => $variantType->id
        ]);

        $values = $values->sortBy(['order']);

        $gotData = $this->repository->getByType($variantType->id);
        $this->assertEquals($values->pluck('id')->toArray(), $gotData->pluck('id')->toArray());
    }
}
