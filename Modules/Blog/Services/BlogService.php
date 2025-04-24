<?php

namespace Modules\Blog\Services;

use Illuminate\Support\Facades\DB;
use Modules\Blog\Repositories\BlogRepository;
use Modules\Core\Traits\Media;
use Throwable;

class BlogService
{
    use Media;

    private string $imageFolder = 'blog';
    private string $thumbFolder = 'blog/thumb';

    public function __construct(protected BlogRepository $repository){}

    public function list(){
        return $this->repository->index();
    }

    public function getItem(string $id){
        return $this->repository->findByField('id', $id);
    }

    public function store(array $data)
    {
        $data["image"] = $this->storeFile($data["image"], $this->imageFolder);
        $sections = $data["sections"];
        unset($data["sections"]);

        if(isset($data["thumbnail"])){
            $data["thumbnail"] = $this->storeFile($data["thumbnail"], $this->thumbFolder);
        }

        try{
            DB::beginTransaction();
            $article = $this->repository->newItem($data);
            $article->sections()->createMany($sections);
            DB::commit();
            return $article;
        }catch (Throwable $e){
            DB::rollBack();
            dd($e->getMessage());
            return false;
        }

    }

    public function update($id, $data): bool
    {
        if(isset($data["sections"])) {
            $sections = $data["sections"];
            unset($data["sections"]);
        }

        if(isset($data["image"])){
            $this->deleteFile($data, "image", $this->imageFolder);
            $data["image"] = $this->storeFile($data["image"], $this->imageFolder);
        }

        if(isset($data["thumbnail"])){
            $this->deleteFile($data, "thumbnail", $this->thumbFolder);
            $data["thumbnail"] = $this->storeFile($data["thumbnail"], $this->thumbFolder);
        }

        try {
            DB::beginTransaction();
            $this->repository->updateItem($id, $data);
            if(isset($sections)){
                $this->repository->storeSections($id, $sections, true);
            }

            DB::commit();

            return true;
        }catch (Throwable){
            DB::rollBack();
            return false;
        }
    }

    public function delete($id): bool
    {
        $data = $this->repository->findByField('id', $id);
        $this->deleteFile($data, "image", $this->imageFolder);
        $this->deleteFile($data, "thumbnail", $this->thumbFolder);

        try {
            DB::beginTransaction();
            $this->repository->remove($id);
            DB::commit();
        } catch (Throwable) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    public function getImage($id): array
    {
        $data = $this->repository->findByField('id', $id);
        return $this->getMedia($data, "image", $this->imageFolder);
    }

    public function getThumbnail($id): array
    {
        $data = $this->repository->findByField('id', $id);
        return $this->getMedia($data, "thumbnail", $this->thumbFolder);
    }

}
