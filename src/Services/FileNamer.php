<?php
namespace Zigtecnologia\Upload\Services;

class FileNamer
{
    public function generate(string $originalName, string $destination): string
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $safeName = bin2hex(random_bytes(8));
        return rtrim($destination, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $safeName . '.' . strtolower($extension);
    }
}
