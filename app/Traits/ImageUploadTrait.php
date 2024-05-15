<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait ImageUploadTrait
{
    /**
     * Handles Image Upload Routines
     *
     * @param \Illuminate\Http\Request $request
     * @param $input_name
     * @param $path
     * @return bool|string
     */
    public function uploadImage(Request $request, $input_name, $path): bool|string
    {
        if ($request->hasFile($input_name)) {
            $image = $request->{$input_name};
            $extension = $image->getClientOriginalExtension();
            $image_name = 'media_' . uniqid() . '.' . $extension;
            $image->move(public_path($path), $image_name);

            return '/' . $path . '/' . $image_name;
        }

        return false;
    }

    /**
     * Handles Multiple Image Upload Routines
     *
     * @param \Illuminate\Http\Request $request
     * @param $input_name
     * @param $path
     * @return bool|array|string
     */
    public function uploadMultiImage(Request $request, $input_name, $path): bool|array|string
    {
        if ($request->hasFile($input_name)) {
            $paths = [];

            $images = $request->{$input_name};

            foreach ($images as $image) {
                $extension = $image->getClientOriginalExtension();
                $image_name = 'media_' . uniqid() . '.' . $extension;

                $image->move(public_path($path), $image_name);

                $paths[] = '/' . $path . '/' . $image_name;
            }

            return $paths;
        }

        return false;
    }

    /**
     * Handles Image Update Routines
     *
     * @param \Illuminate\Http\Request $request
     * @param $input_name
     * @param $path
     * @param null $path_old
     * @return bool|string
     */
    public function updateImage(Request $request, $input_name, $path, $path_old = null): bool|string
    {
        if ($request->hasFile($input_name)) {
//            if (File::exists(public_path($path_old))) {
//                File::delete(public_path($path_old));
//            }

            if ($path_old) {
                $this->deleteImage($path_old);
            }

            $image = $request->{$input_name};
            $extension = $image->getClientOriginalExtension();
            $image_name = 'media_' . uniqid() . '.' . $extension;
            $image->move(public_path($path), $image_name);

            return '/' . $path . '/' . $image_name;
        }

        return false;
    }

    /**
     * Handles Image Delete Routines
     *
     * @param string $path
     */
    public function deleteImage(string $path)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
