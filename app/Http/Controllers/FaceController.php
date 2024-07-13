<?php

namespace App\Http\Controllers;

use App\Helpers\AI\FacePlusPlus\Face;
use App\Http\Requests\FaceDetectRequest;
use App\Http\Requests\FaceDetectPushRequest;
use App\Jobs\DetectImage;
use App\Models\Detect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class FaceController extends Controller
{

//    public function detect(FaceDetectRequest $request)
//    {
//        $response = Face::detect(base64_encode(file_get_contents($request->file('file')->path())));
//
//        if (!$response) {
//            throw ValidationException::withMessages(['ارتباط برقرار نشد! دوباره تلاش کنید.']);
//        }
//
//        return response()->jsonApi($response);
//    }


    public function detect(FaceDetectRequest $request)
    {
        $detect = new Detect();
        $detect->store($request);

        DetectImage::dispatch($detect);

        return response()->jsonApi([
            "token" => $detect->token,
            "push_wait" => 3
        ]);
    }


    public function detectPush(FaceDetectPushRequest $request)
    {
        $detect = Detect::whereToken($request->token)->firstOrFail();

        if ($detect->statusValue() == "Success") {
            return response()->jsonApi([
                "status" => "Success",
                "payload" => json_decode($detect->payload)
            ]);
        }
        else if ($detect->statusValue() == "Waiting") {
            return response()->jsonApi([
                "status" => "Waiting",
                "push_wait" => 3
            ]);
        }
        else if ($detect->statusValue() == "Failed") {
            return response()->jsonApi([
                "status" => "Failed"
            ]);
        }

    }

}
