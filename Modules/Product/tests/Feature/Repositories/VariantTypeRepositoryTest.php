<?php

namespace Modules\Product\tests\Feature\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Models\ProductVariantType;
use Modules\Product\Repositories\VariantTypeRepository;
use Tests\TestCase;
use Tests\Traits\Repositories\TestRepository;

class VariantTypeRepositoryTest extends TestCase
{
    use RefreshDatabase, TestRepository;

    protected VariantTypeRepository $repository;
    protected string $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new VariantTypeRepository();
        $this->model = ProductVariantType::class;
    }

    public function test_it_can_get_by_fields()
    {
        $filterData = ['name' => 'something'];
        $notMatchingData = ['name' => 'another thing'];
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
