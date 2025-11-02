<?php
namespace Zigtecnologia\Upload\Facades;

use Zigtecnologia\Upload\Services\UploadFiles;
use Zigtecnologia\Upload\Services\FileValidator;
use Zigtecnologia\Upload\Services\FileNamer;
use Zigtecnologia\Upload\Services\FileStorage;

class Upload
{
    private array $extensions = [];
    private int $maxSizeMB = 5;
    private string $folder = 'uploads';

    public static function make(): static
    {
        return new static();
    }

    public function extensions(array $extensions): static
    {
        $this->extensions = $extensions;
        return $this;
    }

    public function maxSize(int $maxSizeMB): static
    {
        $this->maxSizeMB = $maxSizeMB;
        return $this;
    }

    public function folder(string $folder): static
    {
        $this->folder = trim($folder, '/');
        return $this;
    }

    public function upload(array $file): string
    {
        $validator = new FileValidator($this->extensions, $this->maxSizeMB);
        $namer = new FileNamer();
        $storage = new FileStorage();

        $uploader = new UploadFiles($validator, $namer, $storage);

        return $uploader->upload($file, $this->folder);
    }
}
