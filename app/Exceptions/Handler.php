<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        AuthorizationException::class,
        NotFoundHttpException::class,
        HttpException::class,
        ModelNotFoundException::class,
        AuthenticationException::class,
        ValidationException::class,
        \InvalidArgumentException::class,
    ];

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        if (request()->is('api/*')) {
            $this->renderable(fn (AuthorizationException $e, $request) =>
                ApiResponse::error(403, 'AuthorizationException', ["error" => $e->getMessage(), "trace" => $e->getTrace()]));

            $this->renderable(fn (NotFoundHttpException $e, $request) =>
                ApiResponse::error(404, 'NotFoundHttpException', ["error" => $e->getMessage(), "trace" => $e->getTrace()]));

            $this->renderable(fn (HttpException $e, $request) =>
                ApiResponse::error(404, 'HttpException', ["error" => $e->getMessage(), "trace" => $e->getTrace()]));

            $this->renderable(fn (ModelNotFoundException $e, $request) =>
                ApiResponse::error(404, 'ModelNotFoundException', ["error" => $e->getMessage(), "trace" => $e->getTrace()]));

            $this->renderable(fn (AuthenticationException $e, $request) =>
                ApiResponse::error(403, 'AuthenticationException', ["error" => $e->getMessage(), "trace" => $e->getTrace()]));

            $this->renderable(fn (ValidationException $e, $request) =>
                ApiResponse::error(401, $e->errors(), ["error" => $e->getMessage(), "trace" => $e->getTrace()]));

        }
    }
}
