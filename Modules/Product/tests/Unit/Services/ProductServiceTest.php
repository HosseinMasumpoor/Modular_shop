<?php

namespace Modules\Product\tests\Unit\Services;

use Illuminate\Database\Eloquent\Builder;
use Mockery;
use Modules\Product\Enums\ProductStatus;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Services\ProductService;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    protected ProductService $service;
    protected ProductRepository $repository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = \Mockery::mock(ProductRepository::class);
        $this->service = new ProductService($this->repository);
    }

    public function test_it_can_get_list(): void
    {
        $mockBuilder = \Mockery::mock(Builder::class);

        $this->repository
            ->shouldReceive('index')
            ->once()
            ->andReturn($mockBuilder);

        $result = $this->service->list();
        $this->assertInstanceOf(Builder::class, $result);
    }

    public function test_it_can_find_by_id(): void
    {
        $mockedModel = Mockery::mock(Product::class);
        $id = 1;

        $this->repository
            ->shouldReceive('findByField')
            ->with('id', $id)
            ->once()
            ->andReturn($mockedModel);
        $result = $this->service->findById(1);
        $this->assertInstanceOf(Product::class, $result);
    }

    public function test_it_can_create(): void
    {
        $data = [
            'name' => 'Test Product',
            'category_id' => 1000,
        ];

        $this->repository
            ->shouldReceive('newItem')
            ->with($data)
            ->once()
            ->andReturnTrue();
        $result = $this->service->store($data);
        $this->assertTrue($result);
    }

    public function test_it_can_update(): void
    {
        $data = [
            'name' => 'Test Product',
            'category_id' => 1000,
        ];
        $id = 1;

        $this->repository
            ->shouldReceive('updateItem')
            ->with($id, $data)
            ->once()
            ->andReturnTrue();

        $result = $this->service->update($id, $data);
        $this->assertTrue($result);
    }

    public function test_it_can_delete(): void
    {
        $id = 1;
        $this->repository
            ->shouldReceive('remove')
            ->with($id)
            ->once()
            ->andReturnTrue();
        $result = $this->service->delete($id);
        $this->assertTrue($result);
    }

    public function test_it_can_change_status(): void
    {
        $id = 1;
        $status = ProductStatus::getRandomInstance();

        $this->repository
            ->shouldReceive('updateItem')
            ->with($id, ['status' => $status])
            ->once()
            ->andReturnTrue();
        $result = $this->service->changeStatus($id, $status);
        $this->assertTrue($result);

    }
}
