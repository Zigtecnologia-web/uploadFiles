<?php
require 'vendor/autoload.php';

use Zigtecnologia\Upload\Facades\Upload;

try {
    $result = Upload::make()
        ->extensions(['jpg', 'png', 'pdf'])
        ->maxSize(10)
        ->folder('docs')
        ->upload($_FILES['arquivo']);

    echo $result;
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
