<?php

namespace Modules\Product\tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Models\Product;
use Tests\TestCase;
use Tests\Traits\Controllers\ResponseStructureTest;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, ResponseStructureTest;

    public function test_it_can_return_all_items(): void
    {
        Product::factory()->count(10)->create();

        $response = $this->getJson(route('api.product.index', ['per_page' => 5]));
        $response->assertOk();
        $this->assertPaginatedSuccessResponse($response, 5, [
            'id',
            'category_id',
            'brand_id',
            'variant_type_id',
            'name',
            'slug',
            'description',
            'status',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'deleted_at',
            'created_at',
            'updated_at',
        ]);
    }

    public function test_it_can_return_an_item(): void
    {
        $products = Product::factory(5)->create();

        $response = $this->getJson(route('api.product.show', $products->first()->id));
        $response->assertOk();
        $response->assertJsonStructure([
            'success' => true,
            'data' => [
                'id',
                'category_id',
                'brand_id',
                'variant_type_id',
                'name',
                'slug',
                'description',
                'status',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'deleted_at',
                'created_at',
                'updated_at',
            ],
            'message' => ""
        ]);

    }

    public function test_it_can_store_an_item(): void
    {
        $data = Product::factory()->make()->toArray();
        $validData = [
            'name',
            'category_id',
            'brand_id',
            'variant_type_id',
            'description',
        ];

        $data = array_filter($data, function ($key) use ($validData) {
            return in_array($key, $validData);
        }, ARRAY_FILTER_USE_KEY);

        $response = $this->postJson(route('api.admin.product.store'), $data);
        $response->assertCreated();
        $this->assertDatabaseHas('products', $data);
        $response->assertJson([
            'success' => true,
            'data' => [],
            'message' => __('core::messages.success'),
        ]);
    }

    public function test_it_can_update_an_item(): void
    {
        $product = Product::factory()->create();
        $data = Product::factory()->make()->toArray();
        $validData = [
            'name',
            'category_id',
            'brand_id',
            'variant_type_id',
            'description',
        ];
        $data = array_filter($data, function ($key) use ($validData) {
            return in_array($key, $validData);
        });
        $response = $this->putJson(route('api.admin.product.update', $product->id), $data);
        $response->assertOk();
        $this->assertDatabaseHas('products', $data);
        $response->assertJson([
            'success' => true,
            'data' => [],
            'message' => __('core::messages.success'),
        ]);
    }

    public function test_it_can_delete_an_item(): void
    {
        $product = Product::factory()->create();
        $response = $this->deleteJson(route('api.admin.product.destroy', $product->id));
        $response->assertOk();
        $this->assertSoftDeleted('products', ['id' => $product->id]);
        $response->assertJson([
            'success' => true,
            'data' => [],
            'message' => __('core::messages.success'),
        ]);
    }
}
