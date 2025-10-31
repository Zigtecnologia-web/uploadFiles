<?php
namespace Zigtecnologia\Upload\Services;

use finfo;
use Zigtecnologia\Upload\Enums\UploadErrorEnum as UploadError;

class FileValidator
{
    public function __construct(
        private array $allowedExtensions = [],
        private int $maxSizeMB = 2
    ) {}

    public function validate(array $file): ?UploadError
    {
        $maxBytes = 1024 * 1024 * $this->maxSizeMB;

        if ($file['size'] > $maxBytes) {
            return UploadError::FILE_TOO_LARGE;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);

        if (empty($file['tmp_name']) || !file_exists($file['tmp_name'])) {
            return UploadError::UNKNOWN_EXTENSION;
        }

        $mimeType = $finfo->file($file['tmp_name']) ?: '';

        if (!preg_match('/(\w+)\/(\w+)/', $mimeType, $matches)) {
            return UploadError::UNKNOWN_EXTENSION;
        }

        $ext = strtolower($matches[2]);

        if (!in_array($ext, $this->allowedExtensions, true)) {
            return UploadError::INVALID_EXTENSION;
        }

        return null;
    }
}
