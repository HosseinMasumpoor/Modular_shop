<?php

namespace Tests\Traits\Models;

trait TestModelRelationStructure
{
    protected function assertBelongsTo($relation, $relatedClass, $model = null): void
    {
        $model = $model ?? $this->getModelClass();
        $this->assertTrue(method_exists($model, $relation), "Relation $relation does not exist on model.");

        $relationInstance = $model->$relation();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relationInstance);
        $this->assertInstanceOf($relatedClass, $relationInstance->getRelated());
    }

    protected function assertHasMany($relation, $relatedClass, $model = null): void
    {
        $model = $model ?? $this->getModelClass();

        $this->assertTrue(method_exists($model, $relation), "Relation $relation does not exist on model.");

        $relationInstance = $model->$relation();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $relationInstance);
        $this->assertInstanceOf($relatedClass, $relationInstance->getRelated());
    }
}
