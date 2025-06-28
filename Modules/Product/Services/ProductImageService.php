<?php

namespace Modules\Product\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Traits\Media;
use Modules\Product\Enums\ProductImageType;
use Modules\Product\Jobs\CreateThumbnailJob;
use Modules\Product\Repositories\ProductImageRepository;

class ProductImageService
{
    use Media;

    protected string $imageFolder = "products";
    protected string $thumbnailFolder = "products/thumbnails";

    public function __construct(protected ProductImageRepository $repository){}

    public function findByProductId(string $productId): Builder
    {
        return $this->repository->getByProduct($productId);
    }

    public function findById(string $id)
    {
        return $this->repository->findByField('id', $id);
    }

    public function store(array $data): bool
    {
        $data['type'] = ProductImageType::NORMAL;

        $images = $this->repository->getByProduct($data['product_id'])->get();

        $data['order'] = $images->count() ? $images->max('order') + 1 : 1;

        if($images->isEmpty()){
            $data['type'] = ProductImageType::MAIN;
        }

        [$absoluteImagePath, $relativeThumbnailPath, $data["image_path"]] = $this->uploadImage($data["image"]);

        unset($data['image']);

        $image = $this->repository->newItem($data);

        dispatch(new CreateThumbnailJob($image->id, $absoluteImagePath, $relativeThumbnailPath));


        return (bool) $image;

    }

    public function update(string $id, array $data): bool
    {
        unset($data['type']);

        if(isset($data["image"]))
        {
            $updatingItem = $this->repository->findByField('id', $id);
            $this->deleteFile($updatingItem, "image_path", $this->imageFolder);
            $this->deleteFile($updatingItem, "thumbnail_path", $this->thumbnailFolder);

            [$absoluteImagePath, $relativeThumbnailPath, $data["image_path"]] = $this->uploadImage($data["image"]);

            dispatch(new CreateThumbnailJob($updatingItem->id, $absoluteImagePath, $relativeThumbnailPath));
        }
        unset($data['image']);
        return $this->repository->updateItem($id, $data);
    }

    public function delete(string $id): bool
    {
        $data = $this->repository->findByField('id', $id);

        if($data['type'] == ProductImageType::NORMAL)
        {
            $this->deleteFile($data, "image_path", $this->imageFolder);
            $this->deleteFile($data, "thumbnail_path", $this->thumbnailFolder);

            return $this->repository->remove($id);
        }
        return false;
    }

    public function changeOrder(string $id, string $substituteId): bool
    {
        $substituteOrder = $this->repository->findByField('id', $substituteId)->order;
        $itemOrder = $this->repository->findByField('id', $id)->order;

        try {
            DB::beginTransaction();

            $this->repository->updateItem($id, [
                'order' => $substituteOrder
            ]);

            $this->repository->updateItem($substituteId,[
                'order' => $itemOrder
            ]);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function orderAllItems(array $ids): bool
    {
        try {
            DB::beginTransaction();
            $order = 1;

            foreach ($ids as $id) {
                $this->repository->updateItem($id, [
                    'order' => $order
                ]);
                $order++;
            }
            return true;
        }catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function changeMainImage(string $productId, string $imageId): bool
    {
        return $this->changeImageType($productId, $imageId, ProductImageType::MAIN);
    }

    public function changeThumbnailImage(string $productId, string $imageId): bool
    {
        return $this->changeImageType($productId, $imageId, ProductImageType::THUMBNAIL);
    }

    public function getImage(string $id): array
    {
        $data = $this->repository->findByField('id', $id);

        return $this->getMedia($data, "image_path", $this->imageFolder);
    }

    public function getThumbnail(string $id): array
    {
        $data = $this->repository->findByField('id', $id);

        return $this->getMedia($data, "thumbnail_path", $this->thumbnailFolder);
    }

    private function uploadImage($image): array
    {
        $data["image_path"] = $this->storeFile($image, $this->imageFolder);

        $relativeImagePath = $this->imageFolder . "/" . $data["image_path"] . "/" . $data["image_path"];
        $absoluteImagePath = Storage::disk('local')->path($relativeImagePath);
        $relativeThumbnailPath = $this->thumbnailFolder . "/" . $data["image_path"] . "/" . $data["image_path"];

        return [
            $absoluteImagePath,
            $relativeThumbnailPath,
            $data["image_path"]
        ];
    }

    private function changeImageType(string $productId, string $imageId, string $imageType): bool
    {
        try {
            DB::beginTransaction();

            $this->repository->updateByFields([
                'product_id' => $productId,
                'type' => $imageType
            ], [
                'type' => ProductImageType::NORMAL
            ]);

            $this->repository->updateItem($imageId, [
                'type' => $imageType
            ]);
            DB::commit();
            return true;
        }catch (\Throwable)
        {
            DB::rollBack();
            return false;
        }
    }

}
