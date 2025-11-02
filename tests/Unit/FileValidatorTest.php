<?php

use Zigtecnologia\Upload\Services\FileValidator;
use Zigtecnologia\Upload\Enums\UploadErrorEnum as UploadError;

beforeEach(function () {
    // Apenas extensões permitidas, mas não vamos testar MIME real
    $this->validator = new FileValidator(
        allowedExtensions: ['jpg','jpeg','png','txt'],
        maxSizeMB: 1
    );

    $this->tmpDir = sys_get_temp_dir() . '/filevalidator_test';
    if (!is_dir($this->tmpDir)) mkdir($this->tmpDir, 0777, true);
});

afterEach(function () {
    foreach (glob($this->tmpDir . '/*') as $f) {
        if (is_file($f)) unlink($f);
    }
    @rmdir($this->tmpDir);
});

it('fails validation for too large file', function () {
    $tmpFile = $this->tmpDir . '/large.txt';
    file_put_contents($tmpFile, str_repeat('a', 2 * 1024 * 1024)); // 2 MB

    $file = [
        'tmp_name' => $tmpFile,
        'size' => 2 * 1024 * 1024,
    ];

    expect($this->validator->validate($file))->toBe(UploadError::FILE_TOO_LARGE);
});

it('fails validation for missing tmp_name', function () {
    $file = [
        'tmp_name' => '',
        'size' => 1024,
    ];

    expect($this->validator->validate($file))->toBe(UploadError::UNKNOWN_EXTENSION);
});

it('fails validation for non-existent tmp file', function () {
    $file = [
        'tmp_name' => '/nonexistent/file.tmp',
        'size' => 1024,
    ];

    expect($this->validator->validate($file))->toBe(UploadError::UNKNOWN_EXTENSION);
});
