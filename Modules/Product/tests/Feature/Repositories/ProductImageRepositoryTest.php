<?php

namespace Modules\Product\tests\Feature\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductImage;
use Modules\Product\Repositories\ProductImageRepository;
use Tests\TestCase;
use Tests\Traits\Repositories\TestRepository;

class ProductImageRepositoryTest extends TestCase
{
    use RefreshDatabase, TestRepository;

    protected ProductImageRepository $repository;
    protected string $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ProductImageRepository();
        $this->model = ProductImage::class;
    }

    public function test_it_can_get_by_fields()
    {
        $filterData = ['image_path' => 'something.jpg'];
        $notMatchingData = ['image_path' => 'another.jpg'];
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
        $images = $this->model::factory(10)->create([
            'product_id' => $product->id
        ]);

        $images = $images->sortBy(['order']);

        $gotImages = $this->repository->getByProduct($product->id);
        $this->assertEquals($images->pluck('id')->toArray(), $gotImages->pluck('id')->toArray());
    }
}
