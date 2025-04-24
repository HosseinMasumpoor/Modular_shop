<?php

namespace Modules\Core\Traits;

use Illuminate\Support\Facades\Storage;
use Modules\Core\Services\StorageService;

trait Media
{
    private function storeFile($file, $folder)
    {
        $fileName = $file->hashName();
        $fullPath = "$folder/$fileName";
        StorageService::addFileStorage($fullPath, $file);
        return $fileName;
    }

    private function deleteFile($data, $filedName, $folder): bool
    {
        if($data[$filedName]){
            return StorageService::removeFileStorage("$folder/$data[$filedName]");
        }
        return false;
    }

    private function getMedia($data, $fieldName, $folder ): array
    {
        $path = $folder . '/' . $data->$fieldName . '/' . $data->$fieldName;
        return $this->getFileAndType($path);
    }

    private function getFileAndType($path): array
    {
        $file = StorageService::getFileStorage($path);
        $type = Storage::mimeType($path);

        return compact('file', 'type');
    }
}
