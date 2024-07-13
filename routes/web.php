<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use \Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::get('maryamhamzei', function () {
    return view('landings.face-detect-1');
});

Route::get('shirinbehjati', function () {
    return view('landings.face-detect-2');
});

//Route::get('exams/{exam:slug}', function (\App\Models\Exam $exam) {
//    $exam->load(['questions']);
////    dd($exam->toArray());
//    return view('landings.exam-0', ['exam' => $exam]);
//});

//Route::get('workers/restart', function () {
//    Artisan::call('queue:restart');
//    exec("php F:/xampp/htdocs/Projects/Instapasion/FaceDetect/artisan queue:restart");
//    $x = exec("php F:/xampp/htdocs/Projects/Instapasion/FaceDetect/artisan queue:work --tries=6 --sleep=1 > /dev/null &");
//    for ($i = 0; $i < 5; $i++) {
//    }
//    "for i in {1..10}; do /path/to/cache.script.sh; done"
//    "/usr/local/bin/php -q php /home/pasioc/public_html/src/artisan queue:work --tries=6 --sleep=1 > /dev/null &"
//    "for i in {1..10}; do /usr/local/bin/php -q php /home/pasioc/public_html/src/artisan queue:work --tries=6 --sleep=1 1>> /dev/null 2>&1; done"
//    return $x;
//    return 'ok';
//});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/storage/local/{filePath}', [\App\Http\Controllers\FileController::class,'fileStorageServe'])->where(['filePath' => '.*']);

    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('home');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/contacts', function () {
        return Inertia::render('Contacts');
    })->name('contacts');
});

Route::get('/exams/{exam:slug}', function ($exam) {
    $exam = \App\Models\Exam::where('slug',$exam)->select(['id','title','slug','description','notice','thumbnail'])->firstOrFail();
    $exam->load('questions:id,exam_id,title,description,media,type,exam_option_id,options,rules,deleted_at');
    $exam->questions_count = $exam->questions->count();
    return Inertia::render('Exams/Show', [
        'exam' => $exam
    ]);
})->name('exams.show');

//Route::get('/exams', function () {
//    $exams = \App\Models\Exam::select(['title','slug','thumbnail','description'])->get();
//    return Inertia::render('Exams/List', [
//        'exams' => $exams
//    ]);
//})->name('exams');

//["گزینه اول","گزینه دوم","گزینه سوم","گزینه چهارم"]
//گزینه اول|گزینه دوم|گزینه سوم|گزینه چهارم
