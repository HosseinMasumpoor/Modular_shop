<?php

namespace Modules\Core\Services;

use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageService
{

    public function makeThumbnail(string $imagePath, string $destinationPath, $width = 300, $height = 300): void
    {
//        $driver = extension_loaded('imagick') ? 'imagick' : 'gd';

        $manager = new ImageManager(new Driver());

        $destinationDir = dirname($destinationPath);
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0775, true);
        }

        $image = $manager->read($imagePath);
        $image->resize($width, $height);
        $image->save($destinationPath);
    }
}
