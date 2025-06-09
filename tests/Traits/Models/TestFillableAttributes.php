<?php

namespace Tests\Traits\Models;

trait TestFillableAttributes
{
    public function assertOnlyFillablePersisted(array $extraData = [], $modelClass = null): void
    {
        $modelClass = $modelClass ?? $this->getModelClass();

        $factoryData = $modelClass::factory()->make();
        $data = array_merge($factoryData->toArray(), $extraData);

        $model = $modelClass::create($data);

        foreach ($extraData as $field => $_) {
            $this->assertFalse(
                isset($model->$field),
                "Field [$field] was not fillable, but it was persisted on " . class_basename($modelClass)
            );
        }

        foreach ($factoryData->toArray() as $field => $value) {
            $this->assertTrue(
                isset($model->$field),
                "Fillable field [$field] was expected to be persisted but was missing."
            );
        }
    }
}
