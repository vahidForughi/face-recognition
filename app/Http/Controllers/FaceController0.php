<?php

namespace App\Http\Controllers;

use App\Helpers\AI\FacePlusPlus\Face;
use App\Http\Requests\FaceDetectRequest;
use Illuminate\Validation\ValidationException;

class FaceController extends Controller
{

    public function detect(FaceDetectRequest $request)
    {
        try {
            $image = new \Imagick();
            $image->readImageBlob((file_get_contents($request->file('file')->path())));
            $image->setImageFormat("jpeg");
            $quality = 100;
            while ($image->getImageLength() > 1400000 && $quality > 40) {
                $quality -= 20;
                $image->setImageCompressionQuality($quality);
            }
            while (strlen($image->getimageblob()) > 1400000 && ($image->getimageWidth() > 800 || $image->getimageHeight() > 800)) {
                $image->resizeImage($image->getimageWidth()/100*80, $image->getimageHeight()/100*80, \Imagick::FILTER_UNDEFINED, 1);
            }
//            $image->writeImage("salam-imagick.jpg");
            $base64 = base64_encode($image->getimageblob());
            if (strlen($base64) > 2000000) {
                throw ValidationException::withMessages(["حجم فایل بیش از حد مجاز است."]);
            }
//            return $quality . '   ****   '.$image->getimageWidth(). '   ****   '.$image->getImageHeight(). '   ****   ' . (base64_encode($image->getimageblob()));
        }
        catch (\ImagickException $ex) {
            /**@var \Exception $ex */
            throw ValidationException::withMessages(["فایل نا معتبر است."]);
        }
//return 'ok';
//        $response = Face::detect(file_get_contents($request->file('file')->path()));
        $response = Face::detect($base64);

        if (!$response) {
            throw ValidationException::withMessages(['ارتباط برقرار نشد! دوباره تلاش کنید.']);
        }

        return response()->jsonApi($response);
    }

}
