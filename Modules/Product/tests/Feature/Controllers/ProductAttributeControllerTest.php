<?php

namespace Modules\Product\tests\Feature\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Admin\Models\Admin;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductAttribute;
use Tests\TestCase;
use Tests\Traits\Controllers\BaseControllerTest;
use Tests\Traits\Controllers\ResponseStructureTest;
use Tests\Traits\Controllers\ValidationTest;

class ProductAttributeControllerTest extends TestCase
{
    use RefreshDatabase, BaseControllerTest, ValidationTest;

    protected string $model;
    private array $fields;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = ProductAttribute::class;
        $this->fields = [
            'product_id',
            'name',
            'value',
        ];

        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
    }

    public function test_it_can_return_items_by_product_id(): void
    {
        Product::factory()->create();
        $this->assertGetItemsByField($this->model, 'api.admin.product.attributes.index', $this->fields, 'product_id', 1);
    }

    public function test_it_can_return_an_item_by_id(): void
    {
        $this->assertFindAnItemById($this->model, 'api.admin.product.attributes.show', $this->fields);
    }

    public function test_it_can_store_an_item(): void
    {
        $this->assertStoreAnItem($this->model, "api.admin.product.attributes.store", $this->fields);
    }

    public function test_it_can_update_an_item(): void
    {
        $fixedValues = [
            'product_id' => Product::factory()->create()->id,
        ];

        $this->assertUpdateAnItem($this->model, "api.admin.product.attributes.update", $this->fields, [], $fixedValues);
    }

    public function test_it_can_delete_an_item(): void
    {
        $this->assertDeleteAnItem($this->model, "api.admin.product.attributes.destroy");
    }

}
