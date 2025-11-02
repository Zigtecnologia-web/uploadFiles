<?php

namespace Zigtecnologia\Upload\Services;

if (!function_exists(__NAMESPACE__ . '\move_uploaded_file')) {
    function move_uploaded_file($from, $to) {
        return rename($from, $to);
    }
}

use Zigtecnologia\Upload\Services\FileStorage;
use Exception;

beforeEach(function () {
    $this->storage = new FileStorage();
    $this->tmpDir = sys_get_temp_dir() . '/filestorage_test';
    if (!is_dir($this->tmpDir)) mkdir($this->tmpDir, 0777, true);
});

afterEach(function () {
    // remove arquivos existentes
    foreach (glob($this->tmpDir . '/*') as $file) {
        if (is_file($file)) unlink($file);
    }

    // remove diretórios existentes
    @rmdir($this->tmpDir . '/nested/folder');
    @rmdir($this->tmpDir . '/nested');
    @rmdir($this->tmpDir);
});

it('saves a file successfully', function () {
    $tmpFile = tempnam(sys_get_temp_dir(), 'upload_');
    file_put_contents($tmpFile, 'test content');

    $targetPath = $this->tmpDir . '/file.txt';
    $file = ['tmp_name' => $tmpFile];

    expect($this->storage->save($file, $targetPath))->toBeTrue();
    expect(file_exists($targetPath))->toBeTrue();
});

it('creates missing directories', function () {
    $tmpFile = tempnam(sys_get_temp_dir(), 'upload_');
    file_put_contents($tmpFile, 'test content');

    $nestedDir = $this->tmpDir . '/nested/folder';
    $targetPath = $nestedDir . '/file.txt';
    $file = ['tmp_name' => $tmpFile];

    expect($this->storage->save($file, $targetPath))->toBeTrue();
    expect(file_exists($targetPath))->toBeTrue();
    expect(is_dir($nestedDir))->toBeTrue();
});

it('throws exception when move fails', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage('Failed to move uploaded file.');

    $file = ['tmp_name' => '/nonexistent/file.tmp'];
    $this->storage->save($file, $this->tmpDir . '/file.txt');
});
