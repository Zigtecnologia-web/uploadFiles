<?php

use Zigtecnologia\Upload\Facades\Upload;
use Zigtecnologia\Upload\Enums\UploadErrorEnum;

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

it('fails validation if an exception is thrown', function () {
    $tmpFile = $this->tmpDir . '/large.txt';
    file_put_contents($tmpFile, str_repeat('a', 2 * 1024 * 1024)); // 2 MB
    $_FILES['arquivo'] = [
        'tmp_name' => $tmpFile,
        'name' => 'large.txt',
        'size' => 2 * 1024 * 1024,
    ];
    $path = Upload::make()
        ->extensions(['txt','jpg','jpeg','png','plain'])
        ->maxSize(3)
        ->folder('uploads')
        ->upload($_FILES['arquivo']);
    expect($path)->toBeString();
    expect(file_exists($path))->toBeTrue();
});
