<?php

namespace Modules\Product\tests\Unit\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Modules\Product\Enums\ProductStatus;
use Modules\Product\Jobs\CreateThumbnailJob;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductAttribute;
use Modules\Product\Models\ProductImage;
use Modules\Product\Repositories\ProductAttributeRepository;
use Modules\Product\Repositories\ProductImageRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Services\ProductAttributeService;
use Modules\Product\Services\ProductImageService;
use Modules\Product\Services\ProductService;
use Tests\TestCase;

class ProductImageServiceTest extends TestCase
{
    protected ProductImageService $service;
    protected ProductImageRepository $repository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = \Mockery::mock(ProductImageRepository::class);
        $this->service = new ProductImageService($this->repository);
    }

    public function test_it_can_find_by_id(): void
    {
        $mockedModel = Mockery::mock(ProductImage::class);
        $id = 1;

        $this->repository
            ->shouldReceive('findByField')
            ->with('id', $id)
            ->once()
            ->andReturn($mockedModel);
        $result = $this->service->findById(1);
        $this->assertInstanceOf(ProductImage::class, $result);
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
            'image_path' => 'some_image.jpg'
        ];

        $this->repository
            ->shouldReceive('newItem')
            ->with($data)
            ->once()
            ->andReturnTrue();
        $result = $this->service->store($data);
        $this->assertTrue($result);

        Bus::assertDispatched(CreateThumbnailJob::class, function (CreateThumbnailJob $job) use ($data) {
            return $job->id == $data['id'];
        });
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

    public function test_it_can_change_order(): void
    {
        $id = 1;

        $newOrder = 5;

        $this->repository
            ->shouldReceive('updateItem')
            ->with($id, ['order' => $newOrder])
            ->once()
            ->andReturnTrue();
        $result = $this->service->changeOrder($id, $newOrder);
        $this->assertTrue($result);
    }
}
