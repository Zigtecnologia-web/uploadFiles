<?php
namespace Zigtecnologia\upload\Services;

use Zigtecnologia\Upload\Services\FileValidator;
use Zigtecnologia\Upload\Services\FileNamer;
use Zigtecnologia\Upload\Services\FileStorage;
use Exception;

class UploadFiles
{
    private FileValidator $validator;
    private FileNamer $namer;
    private FileStorage $storage;

    public function __construct(
        array $extensions = [],
        int $maxSizeMB = 2
    ) {
        $this->validator = new FileValidator($extensions, $maxSizeMB);
        $this->namer = new FileNamer();
        $this->storage = new FileStorage();
    }

    public function upload(array $file, string $folder): string
    {
        $error = $this->validator->validate($file);

        if ($error) {
            throw new Exception("Upload error: " . $error->name);
        }

        $targetPath = $this->namer->generate($file['name'], $folder);

        $this->storage->save($file, $targetPath);

        return $targetPath;
    }
}
