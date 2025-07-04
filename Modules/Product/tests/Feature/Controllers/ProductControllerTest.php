<?php

namespace Modules\Product\tests\Feature\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Admin\Models\Admin;
use Modules\Product\Models\Product;
use Tests\TestCase;
use Tests\Traits\Controllers\BaseControllerTest;
use Tests\Traits\Controllers\ResponseStructureTest;
use Tests\Traits\Controllers\ValidationTest;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, BaseControllerTest, ValidationTest;

    protected string $model;
    private array $fields;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = Product::class;
        $this->fields = [
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
        ];

        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
    }

    public function test_it_can_return_all_items(): void
    {
        $this->assertGetPaginatedItems($this->model, 'api.product.index', $this->fields, 10, 5);
    }

    public function test_it_can_return_an_item(): void
    {
        $this->assertFindAnItemById($this->model, 'api.product.show', $this->fields);
    }

    public function test_it_can_store_an_item(): void
    {
        $validData = [
            'name',
            'category_id',
            'brand_id',
            'variant_type_id',
            'description',
        ];

        $this->assertStoreAnItem($this->model, "api.admin.product.store", $validData);
    }

    public function test_it_can_update_an_item(): void
    {
        $validData = [
            'name',
            'category_id',
            'brand_id',
            'variant_type_id',
            'description',
        ];
        $this->assertUpdateAnItem($this->model, "api.admin.product.update", $validData);
    }

    public function test_it_can_delete_an_item(): void
    {
        $this->assertDeleteAnItem($this->model, "api.admin.product.destroy");
    }

    public function test_store_validation_fails_when_slug_is_not_unique(): void
    {
        $this->assertUniqueFieldValidation($this->model, 'api.admin.product.store', 'slug');
    }

    public function test_store_validation_fails_when_brand_id_is_not_exist(): void
    {
        $this->assertModelNotExistsValidation($this->model, 'api.admin.product.store', 'brand_id');
    }
}
