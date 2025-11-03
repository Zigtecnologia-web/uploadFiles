<?php
namespace Zigtecnologia\Upload\Facades;

use Zigtecnologia\Upload\Services\UploadFiles;
use Zigtecnologia\Upload\Services\FileNamer;
use Zigtecnologia\Upload\Services\FileStorage;
use Zigtecnologia\Upload\Traits\FileValidator;

class Upload
{
    use FileValidator;

    private string $folder = 'uploads';

    public static function make(): static
    {
        return new static();
    }

    public function folder(string $folder): static
    {
        $this->folder = trim($folder, '/');
        return $this;
    }

    public function upload(array $file): string
    {
        $namer = new FileNamer();
        $storage = new FileStorage();

        $uploader = new UploadFiles($this->getFileValidator(), $namer, $storage);

        return $uploader->upload($file, $this->folder);
    }
}
