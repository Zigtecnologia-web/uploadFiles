<?php
namespace Zigtecnologia\Upload\Services;

use Zigtecnologia\Upload\Enums\UploadErrorEnum;
use Zigtecnologia\Upload\Interfaces\FileValidatorRule;

class FileValidator
{
    private array $validatorQueue = [];

    public function addToQueue(FileValidatorRule $rule): self
    {
        $ruleClass = get_class($rule);
        if (isset($this->validatorQueue[$ruleClass])) {
            throw new \InvalidArgumentException(
                "A validation rule of type '{$ruleClass}' has already been added to the queue."
            );
        }
        $this->validatorQueue[$ruleClass] = $rule;

        return $this;
    }

    public function clearQueue(): self
    {
        $this->validatorQueue = [];

        return $this;
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
