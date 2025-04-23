<?php

namespace Modules\Category\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Category\Models\Category;
use Modules\Core\Repositories\Repository;

class CategoryRepository extends Repository
{
    public string|Model $model = Category::class;
}
