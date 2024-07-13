<?php

namespace App\Providers;

use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('jsonApi', function ($value) {
            return ApiResponse::success($value);
        });
        Response::macro('jsonApiError', function ($value) {
            return ApiResponse::success($value);
        });
    }
}
