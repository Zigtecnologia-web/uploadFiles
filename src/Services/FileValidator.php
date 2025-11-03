<?php
namespace Zigtecnologia\Upload\Services;

use Zigtecnologia\Upload\Enums\UploadErrorEnum;
use Zigtecnologia\Upload\Interfaces\FileValidatorRule;

class FileValidator
{
    private array $validatorQueue = [];

    public function addToQueue(FileValidatorRule $rule): void
    {
        $this->validatorQueue[] = $rule;
    }

    public function validate(array $file): ?UploadErrorEnum
    {
        foreach ($this->validatorQueue as $rule) {
            $error = $rule->validate($file);
            if ($error !== null) {
                return $error;
            }
        }

        return null;
    }
}
