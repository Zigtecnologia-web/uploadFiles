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

## To run unit tests with Pest, execute
```php
./vendor/bin/pest
```

## Using the Upload Facade (Fluent API)
```php
require 'vendor/autoload.php';

use Zigtecnologia\Upload\Facades\Upload;

try {
    $path = Upload::make()
        ->extensions(['jpg', 'png', 'pdf'])
        ->maxSize(10)
        ->folder('uploads')
        ->upload($_FILES['arquivo']);

    echo "Saved in: {$path}";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
```