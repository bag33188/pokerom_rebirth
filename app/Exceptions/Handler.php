<?php

namespace App\Exceptions;

use Clockwork\Request\LogLevel;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use MongoDB\Driver\Exception\BulkWriteException;
use MongoDB\Driver\Exception\WriteException;
use PDOException;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

# use Illuminate\Http\Response; // <- has all status code constants

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        PDOException::class => LogLevel::ERROR,
        WriteException::class => LogLevel::CRITICAL,
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(fn(BulkWriteException $e) => throw App::make(MongoWriteException::class,
            ['message' => $e->getMessage(), 'code' => HttpStatus::HTTP_CONFLICT]));

        $this->renderable(fn(QueryException $e) => throw App::make(SqlQueryException::class,
            ['message' => $e->getMessage(), 'code' => HttpStatus::HTTP_CONFLICT]));

        $this->renderable(function (AuthenticationException $e, Request $request): JsonResponse|false {
            $currentErrorRoute = self::getCurrentErrorRouteAsString();
            if ($request->expectsJson()) {
                return response()->json(
                    ['message' => 'Error: Unauthenticated.', 'success' => false], # $e->getTraceAsString();
                    HttpStatus::HTTP_UNAUTHORIZED,
                    [
                        'X-Http-Error-Request-URL' => $currentErrorRoute,
                        'X-Http-Auth-Exception-Original-Message' => $e->getMessage(),
                    ]
                );
            }
            // don't use custom rendering if request is not an API request
            return false;
        });

        $this->renderable(function (HttpException $e, Request $request): JsonResponse|false {
            $currentErrorRoute = self::getCurrentErrorRouteAsString();
            if ($request->is("api/*")) {
                $statusCode = $e->getCode() != 0 ? $e->getCode() : $e->getStatusCode();
                $message = $e->getMessage();
                if ($statusCode === HttpStatus::HTTP_NOT_FOUND && strlen($message) === 0) {
                    $message = "Route not found: $currentErrorRoute";
                }
                return response()->json(
                    ['message' => $message, 'success' => false], # $e->getTrace();
                    $statusCode,
                    [
                        'X-Http-Error-Request-URL' => $currentErrorRoute,
                        ...$e->getHeaders()
                    ]
                );
            }
            // don't use custom rendering if request is not an API request
            return false;
        });
    }


    private static function getCurrentErrorRouteAsString(): string
    {
        $baseAppUrl = Config::get('app.url');
        $currentUrl = URL::current();
        return str_replace("$baseAppUrl/", '/', $currentUrl);
    }
}
