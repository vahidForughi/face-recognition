<?php

namespace App\Jobs;

use App\Helpers\AI\FacePlusPlus\Face;
use App\Models\Detect;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use romanzipp\QueueMonitor\Traits\IsMonitored;

class DetectImage
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $detect;

    /**
     * Create a new job instance.
     */
    public function __construct(Detect $detect)
    {
        $this->detect = $detect;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
//        Log::info('Detect Image');
//        Log::info($this->detect);

        $response = Face::detect(base64_encode(Storage::disk('local')->get('uploads/detects/'.$this->detect->image)));

//        if (!$response->success) {
//            if ($error = "CONCURRENCY_LIMIT_EXCEEDED") {
//
//            }
//        }

        $this->detect->payload = $response;
        $this->detect->status = Detect::statusKey("Success");
        $this->detect->save();

//        Log::info($response);
//        if (!$response) {
//            throw ValidationException::withMessages(['ارتباط برقرار نشد! دوباره تلاش کنید.']);
//        }
//
//        return response()->jsonApi($response);
    }
}
