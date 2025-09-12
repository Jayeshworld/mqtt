<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            Log::info('🔥 Custom unauthenticated handler hit', [
                'expectsJson' => $request->expectsJson(),
                'url' => $request->fullUrl(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Not authenticated',
                ], 401);
            }

            // ✅ Fix: check if route exists, else fallback
            $loginRoute = Route::has('auth.login') ? 'auth.login' : 'login';

            return redirect()->guest(route($loginRoute));
        });
    })
    ->create();
