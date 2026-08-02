<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
   ->withExceptions(function (Exceptions $exceptions): void {

    $exceptions->render(function (
        ValidationException $e,
        Request $request
    ) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    });

    $exceptions->render(function (
        NotFoundHttpException $e,
        Request $request
    ) {
        return response()->json([
            'success' => false,
            'message' => 'Resource not found',
            'errors' => null,
        ], 404);
    });

    $exceptions->render(function (
        HttpException $e,
        Request $request
    ) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage() ?: 'HTTP error',
            'errors' => null,
        ], $e->getStatusCode());
    });

    $exceptions->render(function (
        \Throwable $e,
        Request $request
    ) {
        return response()->json([
            'success' => false,
            'message' => 'Internal server error',
            'errors' => app()->isLocal()
                ? $e->getMessage()
                : null,
        ], 500);
    });
})->create();
