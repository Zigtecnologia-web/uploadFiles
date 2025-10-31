<?php
require 'vendor/autoload.php';

use Zigtecnologia\Upload\UploadFiles;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['arquivo'])) {
        die('Nenhum arquivo enviado. Verifique o campo name="arquivo".');
    }

    $upload = new UploadFiles(['jpg', 'png', 'pdf'], 5);

    try {
        $path = $upload->upload($_FILES['arquivo'], 'uploads');
        echo "Arquivo salvo em: {$path}";
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
