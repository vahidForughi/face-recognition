<?php

namespace App\Helpers\AI\FacePlusPlus;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class Face
{

    static function detect($image, $image_type = 'base64')
    {
        $formData = [
//            'api_key' => "JZICjVlGIw1cNVtwACTGr5EW3ZSurLDD",
//            'api_secret' => "WLWVwQnX5VKJdsslaUomsH24NnYpvvJ6",
            'api_key' => env('FPP_API_KEY'),
            'api_secret' => env('FPP_API_SECRET'),
            'return_landmark' => 0,
            'return_attributes' => 'gender,age,smiling,headpose,facequality,blur,eyestatus,emotion,beauty,mouthstatus,eyegaze,skinstatus',
        ];

        switch ($image_type) {
            case 'base64':
                $formData['image_base64'] = $image;
                break;
            case 'url':
                $formData['image_url'] = $image;
                break;
            case 'file':
                $formData['image_file'] = $image;
                break;
        }

        $response = Http::asForm()->post('https://api-us.faceplusplus.com/facepp/v3/detect', $formData);

        $data = $response->json();

        if (!$response->successful()) {
            if (isset($data["error_message"]))
                throw ValidationException::withMessages([$data["error_message"]]);

            if (!empty($data))
                throw ValidationException::withMessages([$data]);

            throw ValidationException::withMessages(['ارتباط برقرار نشد! دوباره تلاش کنید.']);
        }

        return $data;
    }

}
