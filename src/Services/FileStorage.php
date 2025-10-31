<?php
namespace Zigtecnologia\Upload\Services;

use Exception;

class FileStorage
{
    public function save(array $file, string $targetPath): bool
    {
        $folder = dirname($targetPath);

        if (!is_dir($folder) && !mkdir($folder, 0777, true)) {
            throw new Exception("Failed to create folder: {$folder}");
        }

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new Exception("Failed to move uploaded file.");
        }

        return true;
    }
}
