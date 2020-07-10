<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Venoudev\Results\Exceptions\CheckDataException;
use Venoudev\Results\Exceptions\NotFoundException;
use Venoudev\Results\Exceptions\UnauthorizedPassportException;
use Illuminate\Auth\AuthenticationException;
use Spatie\Permission\Exceptions\UnauthorizedException as UnauthorizedRolException;

use Throwable;
use ResultManager;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof UnauthorizedRolException) {

            $result= ResultManager::createResult();
            $result->fail();
            $result->setCode(401);
            $result->addError('UNAUTHORIZED','You don\'t have permission for this action');
            $result->setDescription('this is posible because that your rol is incorrectly');
            return $result->getJsonResponse();

        }
        if ($exception instanceof NotFoundHttpException) {
            $result= ResultManager::createResult();
            $result->fail();
            $result->setCode(404);
            $result->addError('ROUTE_NOT_FOUND','Invalid route');
            $result->setDescription('this is posible because that your route is incorrectly');
            return $result->getJsonResponse();
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            $result= ResultManager::createResult();
            $result->fail();
            $result->setCode(405);
            $result->addError('VERB_HTTP_INVALID','The verb or method http is not allowed for the server');
            $result->addMessage('CHECK_ROUTE','The route requested could be incorrectly ');
            $result->addMessage('CHECK_VERB','The verb or method http could be incorrectly, remember check the api documentation or check if your verb o method http is [GET, POST, PUT, DELETE]');
            $result->setDescription('this is posible because your method or verb http is incorrectly for the route requested');
            return $result->getJsonResponse();
        }

        if($exception instanceof CheckDataException){
            return $exception->getJsonResponse();
        }
        if($exception instanceof NotFoundException){
            return $exception->getJsonResponse();
        }

        if($exception instanceof FailLoginException){
            return $exception->getJsonResponse();
        }

        if($exception instanceof AuthenticationException){
            $exception_internal = new UnauthorizedPassportException();
            return $exception_internal->getJsonResponse();
        }

        return parent::render($request, $exception);
    }
}
