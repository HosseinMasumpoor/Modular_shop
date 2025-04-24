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

    public function storeSections($id, $data, $hasSections = false): bool
    {
        $record = $this->findByField('id', $id);
        $result = true;
        if (!$hasSections) {
            $result &= $record->sections()->delete();
        }

        foreach ($data as $item) {
            $result &= (bool) $record->sections()->create($item);
        }

        return $result;
    }
}
