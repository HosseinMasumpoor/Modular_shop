<?php

namespace Modules\Product\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Services\ImageService;
use Modules\Product\Repositories\ProductImageRepository;

class CreateThumbnailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $id, public string $absoluteImagePath, public string $thumbnailPath) {}

    /**
     * Execute the job.
     */
    public function handle(ImageService $imageService, ProductImageRepository $repository): void {
        $absoluteThumbnailPath = Storage::disk('local')->path($this->thumbnailPath);
        $imageService->makeThumbnail($this->absoluteImagePath, $absoluteThumbnailPath);
        $repository->updateItem($this->id, [
            'thumbnail_path' => basename($this->thumbnailPath),
        ]);
    }
}
