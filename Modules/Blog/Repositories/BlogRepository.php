<?php

namespace Modules\Blog\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Modules\Blog\Models\Blog;
use Modules\Core\Repositories\Repository;

class BlogRepository extends Repository
{
    public string|Model $model = Blog::class;

    public function index(){
        return app(Pipeline::class)
            ->send($this->query())
            ->through([

            ])
            ->thenReturn()
            ->orderByDesc('created_at');
    }
}
