<?php

use Zigtecnologia\Upload\Facades\Upload;

beforeEach(function () {
    $this->tmpDir = sys_get_temp_dir() . '/filevalidator_test';
    if (!is_dir($this->tmpDir)) mkdir($this->tmpDir, 0777, true);
});

afterEach(function () {
    foreach (glob($this->tmpDir . '/*') as $f) {
        if (is_file($f)) unlink($f);
    }
    @rmdir($this->tmpDir);
});

it('fails if the file has incorrect mimetype', function () {
    $tmpFile = $this->tmpDir . '/large.txt';
    file_put_contents($tmpFile, str_repeat('a', 2 * 1024)); // 2 KB
    $_FILES['arquivo'] = [
        'tmp_name' => $tmpFile,
        'name' => 'large.txt',
        'size' => 2 * 1024,
    ];
    $path = Upload::make()
        ->mimetype(['text/plain'])
        ->folder('uploads')
        ->upload($_FILES['arquivo']);
    expect($path)->toBeString();
    expect(file_exists($path))->toBeTrue();
});

it('throws exception when file has incorrect mimetype', function () {
    $tmpFile = $this->tmpDir . '/document.txt';
    file_put_contents($tmpFile, str_repeat('a', 2 * 1024)); // 2 KB
    $_FILES['arquivo'] = [
        'tmp_name' => $tmpFile,
        'name' => 'document.txt',
        'size' => 2 * 1024,
    ];
    
    expect(fn() => Upload::make()
        ->mimetype(['image/jpeg', 'image/png'])
        ->folder('uploads')
        ->upload($_FILES['arquivo']))
        ->toThrow(Exception::class);
});

it('fails if the file has incorrect extension', function () {
    $tmpFile = $this->tmpDir . '/large.txt';
    file_put_contents($tmpFile, str_repeat('a', 2 * 1024)); // 2 KB
    $_FILES['arquivo'] = [
        'tmp_name' => $tmpFile,
        'name' => 'large.txt',
        'size' => 2 * 1024,
    ];
    $path = Upload::make()
        ->extensions(['txt'])
        ->folder('uploads')
        ->upload($_FILES['arquivo']);
    expect($path)->toBeString();
    expect(file_exists($path))->toBeTrue();
});

it('throws exception when file has incorrect extension', function () {
    $tmpFile = $this->tmpDir . '/document.txt';
    file_put_contents($tmpFile, str_repeat('a', 2 * 1024)); // 2 KB
    $_FILES['arquivo'] = [
        'tmp_name' => $tmpFile,
        'name' => 'document.txt',
        'size' => 2 * 1024,
    ];
    
    expect(fn() => Upload::make()
        ->extensions(['jpg', 'png', 'pdf'])
        ->folder('uploads')
        ->upload($_FILES['arquivo']))
        ->toThrow(Exception::class);
});

it('fails if the file is bigger than test', function () {
    $tmpFile = $this->tmpDir . '/large.txt';
    file_put_contents($tmpFile, str_repeat('a', 2 * 1024 * 1024)); // 2 MB
    $_FILES['arquivo'] = [
        'tmp_name' => $tmpFile,
        'name' => 'large.txt',
        'size' => 2 * 1024 * 1024,
    ];
    $path = Upload::make()
        ->maxSize(3) // 3 MB
        ->folder('uploads')
        ->upload($_FILES['arquivo']);
    expect($path)->toBeString();
    expect(file_exists($path))->toBeTrue();
});

it('throws exception when file has incorrect size', function () {
    $tmpFile = $this->tmpDir . '/document.txt';
    file_put_contents($tmpFile, str_repeat('a', 2 * 1024 * 1024)); // 2 MB
    $_FILES['arquivo'] = [
        'tmp_name' => $tmpFile,
        'name' => 'document.txt',
        'size' => 2 * 1024 * 1024,
    ];
    
    expect(fn() => Upload::make()
        ->maxSize(1) // 1 MB
        ->folder('uploads')
        ->upload($_FILES['arquivo']))
        ->toThrow(Exception::class);
});
