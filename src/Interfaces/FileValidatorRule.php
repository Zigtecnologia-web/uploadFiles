<?php
namespace Zigtecnologia\Upload\Interfaces;

use Zigtecnologia\Upload\Enums\UploadErrorEnum;

interface FileValidatorRule
{
    public function validate(array $file): UploadErrorEnum|null;
}