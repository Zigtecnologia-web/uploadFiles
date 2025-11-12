<?php
namespace Zigtecnologia\Upload\Implementations\FileValidatorRule;

use finfo;
use Zigtecnologia\Upload\Enums\UploadErrorEnum;
use Zigtecnologia\Upload\Interfaces\FileValidatorRule;

class MimeType implements FileValidatorRule
{
    public function __construct(private array $allowedMimeTypes) {}

    public function validate(array $file): UploadErrorEnum|null
    {
        if (empty($file['tmp_name']) || !file_exists($file['tmp_name'])) {
            return UploadErrorEnum::UNKNOWN_EXTENSION;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']) ?: '';

        if (empty($mimeType)) {
            return UploadErrorEnum::UNKNOWN_EXTENSION;
        }

        if (!in_array($mimeType, $this->allowedMimeTypes, true)) {
            return UploadErrorEnum::INVALID_MIMETYPE;
        }

        return null;
    }
}
