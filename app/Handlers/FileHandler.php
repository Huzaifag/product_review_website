<?php

namespace App\Handlers;

use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileHandler
{
    public static function upload(UploadedFile $file, array $options = [])
    {
        $disk = $options['disk'] ?? 'local';
        $name = $options['name'] ?? null;
        $path = $options['path'] ?? null;
        $size = $options['size'] ?? null;
        $oldFile = $options['old_file'] ?? null;

        try {
            $diskInstance = Storage::disk($disk);
            $fileName = self::generateUniqueFileName($file, $name);

            if ($size) {
                $image = ImageManager::gd()->read($file);
                [$width, $height] = explode('x', strtolower($size));
                if ($image->width() != $width || $image->height() != $height) {
                    $image->resize($width, $height);
                }

                $file = $image->encode();

                $uploadFile = $file;
            } else {
                $uploadFile = fopen($file, 'r+');
            }

            if ($oldFile) {
                self::delete($oldFile, $disk);
            }

            $path = rtrim($path, '/') . '/' . $fileName;
            $diskInstance->put($path, $uploadFile);

            return $path;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function download(string $path, ?string $disk = null, ?string $filename = null)
    {
        $disk = $disk ?? 'local';
        $diskInstance = Storage::disk($disk);

        if (!$diskInstance->has($path)) {
            throw new Exception(d_trans('The requested file does not exist.'));
        }

        $filename = $filename ?? basename($path);

        $headers = [
            'Content-Type' => $diskInstance->mimeType($path),
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => $diskInstance->size($path),
        ];

        return new StreamedResponse(function () use ($path, $diskInstance) {
            $stream = $diskInstance->readStream($path);

            while (!feof($stream) && connection_status() === 0) {
                echo fread($stream, 8192);
                flush();
            }

            fclose($stream);
        }, 200, $headers);
    }

    public static function delete(string $path = null, ?string $disk = null): bool
    {
        $disk = $disk ?? 'local';

        try {
            if ($path) {
                $diskInstance = Storage::disk($disk);
                if ($diskInstance->has($path)) {
                    $diskInstance->delete($path);
                }
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function deleteDirectory(string $path = null, $disk = null): bool
    {
        try {
            if ($path) {
                if ($disk) {
                    $diskInstance = Storage::disk($disk);
                    if ($diskInstance->exists($path)) {
                        $diskInstance->deleteDirectory($path);
                    }

                    return true;
                }
                if (File::exists($path)) {
                    File::deleteDirectory($path);
                }
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function makeDirectory(string $path, ?string $disk = null): bool
    {
        try {
            if ($disk) {
                $diskInstance = Storage::disk($disk);
                if ($diskInstance->exists($path)) {
                    $diskInstance->makeDirectory($path);
                }
                return true;
            }

            if (!File::exists($path)) {
                File::makeDirectory($path, 0775, true);
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function generateUniqueFileName($file, ?string $name = null, ?bool $withExtension = true): string
    {
        $extension = $file->getClientOriginalExtension();

        if (!empty($name)) {
            $filename = Str::slug($name);
        } else {
            $filename = Str::random(15) . '_' . time();
        }

        if ($withExtension && !empty($extension)) {
            $filename .= '.' . $extension;
        }

        return $filename;
    }

    public static function imageHasDimensions($image, $size)
    {
        $size = explode('x', strtolower($size));

        $image = ImageManager::gd()->read($image);
        if ($image->width() != $size[0] && $image->height() != $size[1]) {
            return false;
        }

        return true;
    }

    public static function pathToUploadedFile($path, $test = true)
    {
        $filesystem = new Filesystem;

        $name = $filesystem->name($path);
        $extension = $filesystem->extension($path);
        $originalName = $name . '.' . $extension;
        $mimeType = $filesystem->mimeType($path);
        $error = null;

        return new UploadedFile($path, $originalName, $mimeType, $error, $test);
    }
}