<?php
namespace Zigtecnologia\Upload\Implementations\FileValidatorRule;

use Zigtecnologia\Upload\Enums\UploadErrorEnum;
use Zigtecnologia\Upload\Interfaces\FileValidatorRule;

class Extension implements FileValidatorRule
{
    public function __construct(private array $allowedExtensions) {}

    public function validate(array $file): UploadErrorEnum|null
    {
        if (empty($file['name'])) {
            return UploadErrorEnum::UNKNOWN_EXTENSION;
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (empty($extension)) {
            return UploadErrorEnum::UNKNOWN_EXTENSION;
        }

        // Normaliza as extensões permitidas para minúsculas
        $normalizedAllowed = array_map('strtolower', $this->allowedExtensions);

        if (!in_array($extension, $normalizedAllowed, true)) {
            return UploadErrorEnum::INVALID_EXTENSION;
        }

        return null;
    }
}
