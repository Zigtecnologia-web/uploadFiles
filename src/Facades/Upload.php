<?php

namespace Zigtecnologia\Upload\Facades;

use Zigtecnologia\Upload\Services\UploadFiles;

class Upload
{
    private UploadFiles $uploader;
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

    public function upload(mixed $file): mixed
    {
        $this->uploader = new UploadFiles($this->extensions, $this->maxSizeMB);
        return $this->uploader->upload($file, $this->folder);
    }
}
