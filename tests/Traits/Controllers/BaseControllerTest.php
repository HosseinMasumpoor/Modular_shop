<?php

namespace Tests\Traits\Controllers;

trait BaseControllerTest
{
    use ResponseStructureTest;


    public function assertGetPaginatedItems($modelClass, string $routeName, array $fields, $itemsCount = 10, $itemPerPage = 5, $message = null ): void
    {
        $modelClass::factory()->count($itemsCount)->create();

        $response = $this->getJson(route($routeName, ['per_page' => $itemPerPage]));
        $response->assertOk();
        $this->assertPaginatedSuccessResponse($response, $itemPerPage, $fields, $message);
    }

    public function assertGetAllItems($modelClass, string $routeName, array $fields, $itemsCount = 10, $message = null ): void
    {
        $modelClass::factory()->count($itemsCount)->create();

        $response = $this->getJson(route($routeName));
        $response->assertOk();
        $this->assertGetItemsSuccessResponse($response, $itemsCount, $fields, $message);
    }

    public function assertFindAnItemById($modelClass, string $routeName, array $fields, $message = null): void
    {
        $items = $modelClass::factory(5)->create();

        $response = $this->getJson(route($routeName, $items->first()->id));
        $response->assertOk();
        $this->assertSingleItemSuccessResponse($response, $fields, $message);
    }
    public function assertGetItemsByField($modelClass, string $routeName, array $fields, string $searchingField, string $searchingFieldValue, $message = null): void
    {
        $items = $modelClass::factory(5)->create([
            $searchingField => $searchingFieldValue,
        ]);

        $response = $this->getJson(route($routeName, $items->first()->$searchingField));
        $response->assertOk();
        $this->assertGetItemsSuccessResponse($response, 5, $fields, $message);
    }


    public function assertStoreAnItem($modelClass, string $routeName, array $validData, array $files = [], $message = null): void
    {
        $data = $modelClass::factory()->make()->toArray();

        $data = array_filter($data, function ($key) use ($validData) {
            return in_array($key, $validData);
        }, ARRAY_FILTER_USE_KEY);

        if(!empty($files))
        {
            $data = array_merge($data, $files);
        }

        $response = $this->postJson(route($routeName), $data);
        $response->assertCreated();

        foreach($files as $key => $file)
        {
            $data[$key] = $file->hashName();
        }

        $this->assertDatabaseHas((new $modelClass)->getTable(), $data);
        $this->assertCreateItemSuccessResponse($response, $message);
    }

    public function assertUpdateAnItem($modelClass, string $routeName, array $validData, array $files = [], array $fixedValues = [], $message = null): void
    {
        $item = $modelClass::factory()->create($fixedValues);
        $data = $modelClass::factory()->make($fixedValues)->toArray();



        $data = array_filter($data, function ($key) use ($validData) {
            return in_array($key, $validData);
        }, ARRAY_FILTER_USE_KEY);

        if(!empty($files))
        {
            $data = array_merge($data, $files);
        }

        $response = $this->putJson(route($routeName, $item->id), $data);
        $response->assertOk();

        foreach($files as $key => $file)
        {
            $data[$key] = $file->hashName();
        }

        $this->assertDatabaseHas((new $modelClass)->getTable(), $data);
        $this->assertUpdateItemSuccessResponse($response, $message);
    }

    public function assertDeleteAnItem($modelClass, string $routeName, $message = null): void
    {
        $item = $modelClass::factory()->create();
        $response = $this->deleteJson(route($routeName, $item->id));

        $response->assertOk();
        if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses($modelClass))) {
            $this->assertSoftDeleted((new $modelClass)->getTable(), ['id' => $item->id]);
        } else {
            $this->assertDatabaseMissing((new $modelClass)->getTable(), ['id' => $item->id]);
        }
        $this->assertDeleteItemSuccessResponse($response, $message);
    }
}
