<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use MongoDB\Driver\Exception\BulkWriteException;
use MongoDB\Driver\Exception\WriteException;
use PDOException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

#! https://dev.to/jackmiras/laravels-exceptions-part-3-findorfail-exception-automated-4kci

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

        $this->renderable(fn(NotFoundHttpException $e) => throw new NotFoundException($e->getMessage()));
        $this->renderable(fn(QueryException $e) => throw new SqlQueryException($e->getMessage()));
        $this->renderable(fn(BulkWriteException $e) => throw new MongoBulkException($e->getMessage()));
        $this->renderable(fn(MethodNotAllowedHttpException $e) => throw new MethodNotAllowedException($e->getMessage()));
    }
}
