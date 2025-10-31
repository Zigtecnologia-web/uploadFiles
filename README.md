# uploadFiles
A class for handling file uploads using PHP

## 🚀 Features
- Validate file size and extension  
- Define allowed extensions  
- Customizable max upload size  
- Clean and simple API  
- PSR-4 autoload compatible  

## 🧩 Installation
```bash
composer require zigtecnologia/upload
```

## Using UploadFiles directly
```php
require 'vendor/autoload.php';

use Zigtecnologia\Upload\Services\UploadFiles;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['arquivo'])) {
        die('No file uploaded. Check the field name="arquivo".');
    }

    $upload = new UploadFiles(['jpg', 'png', 'pdf'], 5);

    try {
        $path = $upload->upload($_FILES['arquivo'], 'uploads');
        echo "Saved in: {$path}";
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
```

## Using the Upload Facade (Fluent API)
```php
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
```