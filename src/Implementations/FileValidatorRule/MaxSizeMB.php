<?php
namespace Zigtecnologia\Upload\Implementations\FileValidatorRule;

use Zigtecnologia\Upload\Enums\UploadErrorEnum;
use Zigtecnologia\Upload\Interfaces\FileValidatorRule;

class MaxSizeMB implements FileValidatorRule
{
    public function __construct(private int $maxSizeMB) {}

    public function validate(array $file): UploadErrorEnum|null
    {
        if ($file['size'] > ($this->maxSizeMB * 1024 * 1024)) {
            return UploadErrorEnum::FILE_TOO_LARGE;
        }

        return null;
    }
}