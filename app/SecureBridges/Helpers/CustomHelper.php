<?php

namespace App\SecureBridges\Helpers;
use Image;
class CustomHelper
{
    /**
     * save image to directory
     * @param file $image
     * @param string $path
     * @param integer witdh
     * @param integer height
     *
     * @return string
     **/
    public static function saveImage($image, $path, $width, $height)
    {
        $imageLink = '';
        $imageQuality = 75;

        if ($image) {
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            $fileName = time() . uniqid() . '.' . $image->getClientOriginalExtension();
            $imageLink = $path . $fileName;

            if ($image->getClientOriginalExtension() != 'svg') {

                $intvImage = \Image::make($image->getRealPath());
                // $intvImage->width() > $intvImage->height() ? $width = null : $height = null; // resize ratio on dimention's lowest value
                // $intvImage->resize($width, $height, function ($constraint) {
                //     $constraint->aspectRatio();
                // })
                //     ->save($imageLink, $imageQuality);

                $intvImage->resize($width, $height)->save($imageLink);
            } else {
                $image->move(public_path($path), $fileName);
            }
        }

        return $fileName;
    }

    public static function saveBase64Image($image,$path,$width,$height){
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName =  time() . uniqid().'.'.'png';
        \File::put(public_path($path.$imageName), base64_decode($image));
       // Also, after resizing, we save it with the same name in the same place.
        Image::make(public_path($path.$imageName))
        ->resize($width,$height)
        ->save(public_path($path.$imageName));

        return $imageName;
    }

    public static function generateSlug($name, $tableName)
    {
        $slug = \Str::slug($name, '-');
        //$data = \DB::table($tableName)->where('slug', 'like', '%' . $slug . '%')->latest()->first();
        $data = \DB::table($tableName)->where('slug', 'like', '%' . $slug . '%')->orderBy('id', 'desc')->first();
        if (!empty($data)) {
            $pos = strrpos($data->slug, '-');
            $number = substr($data->slug, $pos + 1);
            $number = (int) filter_var($number, FILTER_SANITIZE_NUMBER_INT);
            $slug .= '-' . ($number + 1);
        }
        return $slug;
    }

    public static function limit_text($text, $limit)
    {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
}