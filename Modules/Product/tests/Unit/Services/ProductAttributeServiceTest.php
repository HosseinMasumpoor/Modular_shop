<?php

namespace Modules\Product\tests\Unit\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Modules\Product\Enums\ProductStatus;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductAttribute;
use Modules\Product\Repositories\ProductAttributeRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Services\ProductAttributeService;
use Modules\Product\Services\ProductService;
use Tests\TestCase;

class ProductAttributeServiceTest extends TestCase
{
    protected ProductAttributeService $service;
    protected ProductAttributeRepository $repository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = \Mockery::mock(ProductAttributeRepository::class);
        $this->service = new ProductAttributeService($this->repository);
    }

    public function test_it_can_find_by_id(): void
    {
        $mockedModel = Mockery::mock(ProductAttribute::class);
        $id = 1;

        $this->repository
            ->shouldReceive('findByField')
            ->with('id', $id)
            ->once()
            ->andReturn($mockedModel);
        $result = $this->service->findById(1);
        $this->assertInstanceOf(ProductAttribute::class, $result);
    }

    public function test_it_can_get_items_by_product_id(): void
    {
        $mockedCollection = Mockery::mock(Collection::class);
        $productId = 1;
        $this->repository
            ->shouldReceive('getByFields')
            ->with(['product_id' => $productId])
            ->once()
            ->andReturn($mockedCollection);
        $result = $this->service->findByProductId($productId);
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function test_it_can_create(): void
    {
        $data = [
            'product_id' => 1,
            'name' => 'some attribute',
            'value' => 'some value',
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
            'product_id' =>1,
            'name' => 'another attribute',
            'value' => 'another value',
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
}
