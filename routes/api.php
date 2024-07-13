<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use \App\Models\ExamQuestion;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    $x = \App\Helpers\General\Utils::arrayToMatrix(['aaa', 'bbb','ccc']);
    dd($x);
});


Route::post('face/detect/push', [\App\Http\Controllers\FaceController::class, 'detectPush'])
    ->middleware('throttle:forms')
;
Route::post('face/detect', [\App\Http\Controllers\FaceController::class, 'detect'])
    ->middleware('throttle:forms')
;

Route::middleware('throttle:forms')->post('contact', [\App\Http\Controllers\ContactController::class, 'store']);

Route::get('exams/{exam:slug}', [\App\Http\Controllers\ExamsController::class, 'show']);
Route::post('exams/{exam:slug}/participants', [\App\Http\Controllers\ExamsController::class, 'storeParticipant']);


//Route::post('speedtest', function (\Illuminate\Http\Request $request) {
//    $time = floor(microtime(true) * 1000);
//
//    for ($i = 0; $i < 10; $i++) {
//        $contact = new \App\Models\Contact();
//        $contact->store($request);
//    }
//
//    return floor(microtime(true) * 1000) - $time;
//});

