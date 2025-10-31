<?php
namespace Zigtecnologia\Upload\Enums;

enum UploadErrorEnum: int 
{
    case INVALID_EXTENSION = 1;
    case FILE_TOO_LARGE = 2;
    case UNKNOWN_EXTENSION = 3;
    case SAVE_FAILED = 4;
}
