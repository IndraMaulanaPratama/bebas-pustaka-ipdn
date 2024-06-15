<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
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
    }

    public function render($request, Throwable $exception)
    {
        // Cék naha pamundut ngaharepkeun réspon JSON
        if ($request->wantsJson() || $request->is('api/*')) {

            // Nangtukeun status HTTP dumasar kana jinis éksepsi
            if ($this->isHttpException($exception)) {
                $status = $exception->getStatusCode();
            }

            // Ngolah éksepsi JWT spésifik
            if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                $status = 401;
                $response['errors'] = 'Token is invalid';
            } else if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                $status = 401;
                $response['errors'] = 'Token has expired';
            } else if ($exception instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
                $status = 401;
                $response['errors'] = $exception->getMessage();
            } else if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                $status = 401;
                $response['errors'] = 'Authentication error';
            } else {
                $status = 500;
                $response['errors'] = $exception->getMessage();
            }

            return response()->json($response, $status);
        }

        return parent::render($request, $exception);
    }
}
