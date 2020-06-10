<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function name_image($str)
    {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/(_| )/', '-', $str);
        $str = substr($str, 0, 20);
        return $str . '-' . time();
    }

    public function saveImgBase64($param, $folder)
    {
        if (!is_dir('images/' . $folder)) {
            mkdir('images/' . $folder);
        }
        $base64_str = substr($param, strpos($param, ",") + 1);
        $image = base64_decode($base64_str);
        $png_url = "image.jpg";
        $path = public_path('images/' . $folder . '/' . $png_url);
        file_put_contents($path, $image);
        return $png_url;
    }

    public function deleteFolder($folder)
    {
        if (is_dir($folder)) {
            $objects = scandir($folder);

            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($folder . '/' . $object) == "dir") remove_dir($folder . '/' . $object);
                    else unlink($folder . '/' . $object);
                }
            }
            reset($objects);
            rmdir($folder);
        }
    }
}
