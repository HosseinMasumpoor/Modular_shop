<?php

namespace Modules\Product\tests\Feature\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Models\Admin;
use Modules\Product\Models\Brand;
use Modules\Product\Models\Product;
use Tests\TestCase;
use Tests\Traits\Controllers\BaseControllerTest;
use Tests\Traits\Controllers\ResponseStructureTest;
use Tests\Traits\Controllers\ValidationTest;

class BrandControllerTest extends TestCase
{
    use RefreshDatabase, BaseControllerTest, ValidationTest;

    protected string $model;
    private array $fields;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = Brand::class;
        $this->fields = [
            'name',
            'slug',
            'logo',
            'description',
            'meta_title',
            'meta_description',
            'meta_keywords',
        ];

        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
    }

    public function test_it_can_return_all_items(): void
    {
        $this->assertGetAllItems($this->model, 'api.brand.index', $this->fields, 10);
    }

    public function test_it_can_return_an_item(): void
    {
        $this->assertFindAnItemById($this->model, 'api.brand.show', $this->fields);
    }

    public function test_it_can_store_an_item(): void
    {
        $validData = [
            'name',
            'slug',
            'logo',
            'description',
            'meta_title',
            'meta_description',
            'meta_keywords',
        ];

        $logoFile = UploadedFile::fake()->image('logo.jpg');

        $files = [
            'logo' => $logoFile
        ];

        $this->assertStoreAnItem($this->model, "api.admin.brand.store", $validData, $files);
        Storage::assertExists("brands/logo/" . $logoFile->hashName() . "/" . $logoFile->hashName());

    }

    public function test_it_can_update_an_item(): void
    {
        $validData = [
            'name',
            'slug',
            'logo',
            'description',
            'meta_title',
            'meta_description',
            'meta_keywords',
        ];

        $logoFile = UploadedFile::fake()->image('logo.jpg');
        $files = [
            'logo' => $logoFile
        ];

        $this->assertUpdateAnItem($this->model, "api.admin.brand.update", $validData, $files);
        Storage::assertExists("brands/logo/" . $logoFile->hashName() . "/" . $logoFile->hashName());
    }

    public function test_it_can_delete_an_item(): void
    {
        $this->assertDeleteAnItem($this->model, "api.admin.brand.destroy");
    }

    public function test_store_validation_fails_when_slug_is_not_unique(): void
    {
        $this->assertUniqueFieldValidation($this->model, 'api.admin.brand.store', 'slug');
    }

}
