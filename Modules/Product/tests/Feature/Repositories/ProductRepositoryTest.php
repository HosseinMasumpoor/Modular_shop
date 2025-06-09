<?php

namespace Modules\Product\tests\Feature\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Enums\ProductStatus;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;
use Tests\TestCase;
use Tests\Traits\Repositories\TestRepository;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase, TestRepository;

    protected ProductRepository $repository;
    protected string $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ProductRepository();
        $this->model = Product::class;
    }

    public function test_it_can_get_by_fields()
    {
        $filterData = ['status' => ProductStatus::ACTIVE];
        $notMatchingData = ['status' => ProductStatus::INACTIVE];
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
}
