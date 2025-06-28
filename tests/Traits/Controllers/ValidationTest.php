<?php

namespace Tests\Traits\Controllers;

trait ValidationTest
{
    public function assertUniqueFieldValidation($modelClass, string $routeName, string $field, bool $isPutMethod = false, array $extra = [], $message = ''): void
    {
        $modelClass::factory()->create([$field => 'duplicated']);
        $data = array_merge(
            $modelClass::factory()->make()->toArray(),
            [$field => 'duplicated'],
            $extra
        );

        if($isPutMethod) {
            $newInstance = $modelClass::factory()->create([$field => 'another thing']);
            $response = $this->putJson(route($routeName, $newInstance->id), $data);
        }else {
            $response = $this->postJson(route($routeName), $data);
        }
        $response->assertStatus(422)->assertJsonValidationErrors($field);
    }

    public function assertModelNotExistsValidation($modelClass, string $routeName, string $field, bool $isPutMethod = false, $message = ''): void
    {
        $nonExistentId = $modelClass::max('id') + 100;

        $data = $modelClass::factory()->make([$field => $nonExistentId])->toArray();

        if ($isPutMethod)
        {
            $newInstance = $modelClass::factory()->create();
            $response = $this->putJson(route($routeName, $newInstance->id), $data);
        }
        else{
            $response = $this->postJson(route($routeName), $data);
        }

        $response->assertStatus(422)->assertJsonValidationErrors($field);
    }
}
