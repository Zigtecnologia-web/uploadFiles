<?php
namespace Zigtecnologia\Upload\Traits;

use Zigtecnologia\Upload\Implementations\FileValidatorRule\MaxSizeMB;
use Zigtecnologia\Upload\Implementations\FileValidatorRule\MimeType;
use Zigtecnologia\Upload\Services\FileValidator as FileValidatorService;

trait FileValidator
{
    private FileValidatorService $fileValidator;

    public function extensions(array $allowedExtensions): static
    {
        $this->getFileValidator()->addToQueue(new MimeType($allowedExtensions));

        return $this;
    }

    public function maxSize(int $maxSizeMB): static
    {
        $this->getFileValidator()->addToQueue(new MaxSizeMB($maxSizeMB));

        return $this;
    }

    public function getFileValidator(): FileValidatorService
    {
        if (!isset($this->fileValidator)) {
            $this->fileValidator = new FileValidatorService();
        }

        return $this->fileValidator;
    }
}