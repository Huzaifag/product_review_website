<?php

namespace App\Classes;

use App\Handlers\FileHandler;
use Illuminate\Support\Facades\File;
use WebPConvert\WebPConvert;

class ImageToWebp
{
    public static function convert($file)
    {
        $tempFileName = FileHandler::generateUniqueFileName($file);
        $tempFilePath = storage_path("app/temp/");
        FileHandler::makeDirectory($tempFilePath);

        $file->move($tempFilePath, $tempFileName);
        $fileSource = $tempFilePath . $tempFileName;

        $filename = FileHandler::generateUniqueFileName($file, null, false);
        $fileDestination = storage_path("app/temp/{$filename}.webp");
        WebPConvert::convert($fileSource, $fileDestination);

        File::delete($fileSource);

        return FileHandler::pathToUploadedFile($fileDestination);
    }
}