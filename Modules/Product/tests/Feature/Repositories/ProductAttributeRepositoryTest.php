<?php

namespace Modules\Product\tests\Feature\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Enums\ProductStatus;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductAttribute;
use Modules\Product\Repositories\ProductAttributeRepository;
use Modules\Product\Repositories\ProductRepository;
use Tests\TestCase;
use Tests\Traits\Repositories\TestRepository;

class ProductAttributeRepositoryTest extends TestCase
{
    use RefreshDatabase, TestRepository;

    protected ProductAttributeRepository $repository;
    protected string $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ProductAttributeRepository();
        $this->model = ProductAttribute::class;
    }

    public function test_it_can_get_by_fields()
    {
        $filterData = ['name' => 'some key'];
        $notMatchingData = ['name' => 'another key'];
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

    public function test_it_can_get_all_product_attributes()
    {
        $product = Product::factory()->create();
        $productAttributes = $this->model::factory(10)->create([
            'product_id' => $product->id
        ]);

        $productAttributes = $productAttributes->sortBy(['order', 'name']);

        $attributes = $this->repository->getByProduct($product->id);
        $this->assertEquals($productAttributes->pluck('id')->toArray(), $attributes->pluck('id')->toArray());
    }
}
