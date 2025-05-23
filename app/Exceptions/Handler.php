<?php

namespace App\Exceptions;

use App\Helpers\Responses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    function render($request, Throwable $e)
    {
        if ($this->isHttpException($e)) {
            return Responses::error(
                [],
                $e->getStatusCode(),
                $e->getMessage()
            );
        }

        $this->renderable(function (ModelNotFoundException $e, $request) {
            return Responses::error(
                [],
                404,
                $e->getMessage()
            );        });
        $this->renderable(function (NotFoundHttpException $e, $request) {
            return Responses::error(
                [],
                404,
                $e->getMessage()
            );
        });
        return parent::render($request, $e); // TODO: Change the autogenerated stub
    }
}
