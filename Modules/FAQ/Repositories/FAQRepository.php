<?php

namespace Modules\FAQ\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Modules\Core\Repositories\Repository;
use Modules\FAQ\Models\FAQ;

class FAQRepository extends Repository
{
    public string|Model $model = FAQ::class;

    public function newItem($data): Model
    {
        $data["order"] = FAQ::lastOrder() + 1;
        return parent::newItem($data);
    }

    public function Index(): Builder
    {
        return app(Pipeline::class)
            ->send(
                (new self)->query()
            )
            ->thenReturn()
            ->orderByDesc('created_at');
    }
}
