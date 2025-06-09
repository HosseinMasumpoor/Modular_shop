<?php

namespace Tests\Traits\Models;

use Illuminate\Database\Eloquent\Collection;

trait TestModelRelations
{

    public function assertBelongsToRelation($relation, $relatedModelClass, $foreignKey, $modelClass = null): void
    {
        $modelClass = $modelClass ?? $this->getModelClass();

        $related = $relatedModelClass::factory()->create();
        $model = $modelClass::factory()->create([$foreignKey => $related->id]);

        $this->assertInstanceOf(
            $relatedModelClass,
            $model->$relation,
            "Expected '$relation' to return instance of $relatedModelClass"
        );
        $this->assertEquals($related->id, $model->$relation->id);
    }

    public function assertHasManyRelation($relation, $relatedModelClass, $foreignKey, $modelClass = null, int $count = 5): void
    {
        $modelClass = $modelClass ?? $this->getModelClass();

        $model = $modelClass::factory()->create();
        $relationInstances = $relatedModelClass::factory($count)->create([$foreignKey => $model->id]);

        $this->assertNotNull($model->$relation, "Relation '$relation' is not defined or returns null.");
        $this->assertInstanceOf(Collection::class, $model->$relation);
        $this->assertInstanceOf($relatedModelClass, $model->$relation->first());
        $this->assertCount($count, $model->$relation, "Expected $count related records for '$relation'");
        $this->assertTrue(
            $relationInstances->pluck('id')->diff($model->$relation->pluck('id'))->isEmpty(),
            "The related records of '$relation' do not match the expected instances."
        );
    }
}
