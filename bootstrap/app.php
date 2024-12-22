<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $data['success'] = false;

        $exceptions->render(function (AuthenticationException $e, Request $request) use ($data) {
            if ($request->is('api/*')) {
                $data['message'] = $e->getMessage() ?? 'Unauthenticated';
                return response()->json($data, Response::HTTP_UNAUTHORIZED);
            }
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) use ($data) {
            if ($request->is('api/*')) {
                $data['message'] = $e->getMessage();
                return response()->json($data, Response::HTTP_NOT_FOUND);
            }
        });

        $exceptions->render(function (UnprocessableEntityHttpException $e, Request $request) use ($data) {
            if ($request->is('api/*')) {
                $data['message'] = $e->getMessage();
                return response()->json($data, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });

        $exceptions->render(function (\PDOException $e, Request $request) use ($data) {
            if ($request->is('api/*')) {
                $data['message'] = config('message.server_error');
                return response()->json($data, Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
        
        $exceptions->render(function (\Exception $e, Request $request) use ($data) {
            if ($request->is('api/*')) {
                $data['message'] = config('message.unable_to_process');
                return response()->json($data, Response::HTTP_BAD_REQUEST);
            }
        });

        $exceptions->render(function (\Error $e, Request $request) use ($data) {
            if ($request->is('api/*')) {
                $data['message'] = config('message.unable_to_process');
                return response()->json($data, Response::HTTP_BAD_REQUEST);
            }
        });

    })->create();


