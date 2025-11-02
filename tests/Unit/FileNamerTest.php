<?php

use Zigtecnologia\Upload\Services\FileNamer;

it('generates file name with preserved extension', function () {
    $namer = new FileNamer();
    $path = $namer->generate('foto.JPG', '/uploads');
    expect($path)
        ->toStartWith('/uploads/')
        ->and($path)->toEndWith('.jpg');
});

it('removes duplicate slash in the destination', function () {
    $namer = new FileNamer();
    $path = $namer->generate('arquivo.txt', '/uploads/');
    expect($path)
        ->toStartWith('/uploads/')
        ->and($path)->toEndWith('.txt');
});

it('generates unique names on each call', function () {
    $namer = new FileNamer();
    $a = $namer->generate('a.pdf', '/tmp');
    $b = $namer->generate('a.pdf', '/tmp');
    expect($a)->not->toBe($b);
});
