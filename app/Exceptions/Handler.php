<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Psy\Exception\ErrorException;
use Psy\Exception\FatalErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\QueryException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
            if(explode( '/',$request->getPathInfo())[1] == 'api') {
                //dd($exception);
                if ($exception instanceof ModelNotFoundException) {
                    $model = strtolower(class_basename($exception->getModel()));
                    return $this->errorResponse("Does not exits any instance of {$model} with the given", 404);
                }
                if ($exception instanceof AuthorizationException) {
                    return $this->errorResponse($exception->getMessages(), 403);
                }
                if ($exception instanceof AuthenticationException) {
                    return $this->errorResponse("Please login again", 401);
                }
                if ($exception instanceof ValidationException) {

                    return $this->errorResponse($exception->validator->errors()->getMessages(), 414);
                }
                if ($exception instanceof MethodNotAllowedHttpException) {

                    return $this->errorResponse("Method not allowed", 405);
                }
                if ($exception instanceof QueryException) {
                    return $this->errorResponse($exception->getMessage(), 400);
                }
                if ($exception instanceof TokenInvalidException) {
                    return $this->errorResponse("Token valid", 463);
                }
                if ($exception instanceof TokenExpiredException) {
                    return $this->errorResponse("Token expired", 406);
                }
                if ($exception instanceof JWTException) {
                    return $this->errorResponse($exception->getMessage(), 410);
                }
                if ($exception instanceof UnauthorizedHttpException) {
                    return $this->errorResponse($exception->getMessage(), 406);
                }
                if ($exception instanceof FatalErrorException) {
                    return $this->errorResponse($exception->getMessage(), 407);
                }
                if ($exception instanceof MassAssignmentException) {
                    return $this->errorResponse($exception->getMessage(), 408);
                }
                if ($exception instanceof ErrorException) {
                    return $this->errorResponse($exception->getMessage(), 409);
                }
                if ($exception instanceof InvalidArgumentException) {
                    return $this->errorResponse($exception->getMessage(), 411);
                }
                if ($exception instanceof NotFoundHttpException) {
                    return $this->errorResponse("URL not found", 415);
                }
                if (env('APP_DEBUG') == false) {
                    return parent::render($request, $exception);
                }
                return $this->errorResponse("Unexpected error. Try later", 500);
            }else {
                return parent::render($request, $exception);
            }

    }
    public function unauthenticated($request, AuthenticationException $exception)
    {
        if($request->expectsJson()){
            return response()->json(['error' => 'unauthenticated'], 401);
        }
        foreach ($exception->guards() as $key => $guard){
            if($key==0){
                break;
            }
        }

        //$guard = array_pop($exception->guards());
        switch ($guard){
            case 'admin':
                $login= 'admin.login';
                break;
            default:
                $login= 'login';
                break;
        }

        return redirect()->guest(route($login));
    }
}
