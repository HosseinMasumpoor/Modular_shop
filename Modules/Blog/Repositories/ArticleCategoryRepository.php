<?php

namespace Modules\Blog\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Models\ArticleCategory;
use Modules\Core\Repositories\Repository;

class ArticleCategoryRepository extends Repository
{
    public string|Model $model = ArticleCategory::class;
}
