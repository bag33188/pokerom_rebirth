<?php

namespace App\Exceptions;

use App;
use Config;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MongoDB\Driver\Exception\BulkWriteException;
use MongoDB\Driver\Exception\WriteException;
use PDOException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use URL;

//use Illuminate\Http\Response;

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
            ['message' => $e->getMessage(), 'code' => HttpResponse::HTTP_CONFLICT]));
        $this->renderable(fn(QueryException $e) => throw App::make(SqlQueryException::class,
            ['message' => $e->getMessage(), 'code' => HttpResponse::HTTP_CONFLICT]));
        $this->renderable(function (AuthenticationException $e, Request $request): ?JsonResponse {
            if ($request->expectsJson()) {
                return jsonData(['message' => 'Unauthenticated.'], HttpResponse::HTTP_UNAUTHORIZED);
            }
            return null;
        });
        $this->renderable(function (HttpException $e, Request $request): ?JsonResponse {
            $currentRoute = str_replace(Config::get('app.url'), '', URL::current());
            if ($request->is("api/*", "/public/api/*")) {
                $statusCode = $e->getStatusCode();
                $message = $e->getMessage();
                if ($statusCode === HttpResponse::HTTP_NOT_FOUND && strlen($message) === 0) {

                    $message = "Route not found: $currentRoute";
                }
                return jsonData(['message' => $message], $statusCode, array('X-Http-Error-Request-URI' => $currentRoute));
            }
            return null;
        });
    }
}
