<?php

namespace Tests\Traits\Repositories;

trait TestRepository
{
    public function assertGetByFields($modelClass, $repository, $filterData, $notMatchingData)
    {
        $modelClass::factory()->create($filterData);

        $modelClass::factory()->create($notMatchingData);
        $data = $repository->getByFields($filterData);

        $this->assertCount(1, $data);

        foreach ($filterData as $field => $value) {
            $this->assertEquals($value, $data->first()->$field);
        }
    }

    public function assertCreateNewItem($modelClass, $repository)
    {
        $data = $modelClass::factory()->make()->toArray();
        $repository->newItem($data);

        $this->assertDatabaseHas((new $modelClass)->getTable(), $data);
    }

    public function assertFindByField($modelClass, $repository, $field)
    {
        $data = $modelClass::factory()->create();
        $found = $repository->findByField($field, $data->$field);

        $this->assertEquals($data->$field, $found->$field);
    }

    public function assertUpdateItem($modelClass, $repository)
    {
        $createdItem = $modelClass::factory()->create();

        $data = $modelClass::factory()->make()->toArray();

        $repository->updateItem($createdItem->id, $data);
        $this->assertDatabaseHas((new $modelClass)->getTable(), $data);
    }

    public function assertRemoveItem($modelClass, $repository)
    {
        $item = $modelClass::factory()->create();
        $repository->remove($item->id);

        $this->assertDatabaseMissing((new $modelClass)->getTable(), ['id' => $item->id]);
    }
}
