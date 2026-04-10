<?php

namespace App\Http\Controllers\Admin;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\EditorImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,gif,webp,svg+xml,bmp,tiff,heic,heif', 'max:4096'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return response()->json(['error' => $error], 400);
            }
        }

        $image = $request->file('image');

        if (!in_array($image->getClientMimeType(), [
            'image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/webp', 'image/svg+xml', 'image/bmp', 'image/tiff', 'image/heic', 'image/heif',
        ])) {
            return response()->json([
                'error' => d_trans('Invalid image type, the uploaded image type are not supported.'),
            ], 400);
        }

        try {
            $name = $image->getClientOriginalName();

            $image = FileHandler::upload($image, [
                'path' => 'images/embed/',
            ]);

            if (!$image) {
                return response()->json(['data' => [
                    'error' => 'Failed to upload the image.',
                ]], 500);
            }

            $editorImage = new EditorImage();
            $editorImage->name = $name;
            $editorImage->path = $image;
            $editorImage->save();

            $size = getimagesize($image);

            return response()->json([
                'success' => true,
                'data' => [
                    'link' => $editorImage->getLink(),
                    'width' => $size[0],
                ],
            ]);
        } catch (Exception $e) {
            return response()->json(['data' => [
                'error' => 'An error occurred: ' . $e->getMessage(),
            ]], 500);
        }
    }
}
