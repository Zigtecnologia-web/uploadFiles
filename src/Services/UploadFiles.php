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
        FileValidator $validator,
        FileNamer $namer,
        FileStorage $storage
    ) {
        $this->validator = $validator;
        $this->namer = $namer;
        $this->storage = $storage;
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
