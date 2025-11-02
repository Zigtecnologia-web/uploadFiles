<?php

namespace Zigtecnologia\Upload\Services;

use Exception;
use Zigtecnologia\Upload\Enums\UploadErrorEnum as UploadError;
use PHPUnit\Framework\MockObject\MockObject;

beforeEach(function () {
    /** @var FileValidator&MockObject */
    $this->validator = $this->createMock(FileValidator::class);

    /** @var FileNamer&MockObject */
    $this->namer = $this->createMock(FileNamer::class);

    /** @var FileStorage&MockObject */
    $this->storage = $this->createMock(FileStorage::class);

    $this->uploader = new UploadFiles($this->validator, $this->namer, $this->storage);

    $this->file = [
        'name' => 'test.jpg',
        'tmp_name' => '/tmp/test.jpg',
        'size' => 1024,
    ];

    $this->folder = '/uploads';
});

it('uploads a file successfully', function () {
    $this->validator->method('validate')->willReturn(null);
    $this->namer->method('generate')->willReturn('/uploads/unique.jpg');
    $this->storage->expects($this->once())
                  ->method('save')
                  ->with($this->file, '/uploads/unique.jpg')
                  ->willReturn(true);

    $path = $this->uploader->upload($this->file, $this->folder);

    expect($path)->toBe('/uploads/unique.jpg');
});

it('throws exception when validation fails', function () {
    $this->validator->method('validate')->willReturn(UploadError::INVALID_EXTENSION);

    $this->namer->expects($this->never())->method('generate');
    $this->storage->expects($this->never())->method('save');

    $closure = fn() => $this->uploader->upload($this->file, $this->folder);
    expect($closure)->toThrow(Exception::class, 'Upload error: INVALID_EXTENSION');
});

it('throws exception when storage fails', function () {
    $this->validator->method('validate')->willReturn(null);
    $this->namer->method('generate')->willReturn('/uploads/unique.jpg');
    $this->storage->method('save')->willThrowException(new Exception("Failed to move uploaded file."));

    $closure = fn() => $this->uploader->upload($this->file, $this->folder);
    expect($closure)->toThrow(Exception::class, 'Failed to move uploaded file.');
});
