<?php

namespace Modules\Product\Services;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Traits\Media;
use Modules\Product\Models\Brand;
use Modules\Product\Repositories\BrandRepository;

class BrandService
{
    use Media;
    private string $logoFolder = 'brands/logo';

    public function __construct(protected BrandRepository $repository){}

    public function list(): Builder
    {
        return $this->repository->index();
    }

    public function findById(string $id): ?Brand
    {
        return $this->repository->findByField('id', $id);
    }

    public function store(array $data): bool
    {
        if(isset($data['logo'])){
            $data["logo"] = $this->storeFile($data['logo'], $this->logoFolder);
        }
        return (bool) $this->repository->newItem($data);
    }

    public function update(string $id, array $data): bool
    {
        if(isset($data['logo'])){
            $data["logo"] = $this->storeFile($data['logo'], $this->logoFolder);
            $prevData = $this->findById($id)->toArray();
            $this->deleteFile($prevData, "logo", $this->logoFolder);
        }
        return $this->repository->updateItem($id, $data);
    }

    public function delete(string $id): bool
    {
        return $this->repository->remove($id);
    }

    public function getLogo(string $id): array
    {
        $data = $this->findById($id);
        return $this->getMedia($data, "logo", $this->logoFolder);
    }
}
