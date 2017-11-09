<?php

namespace RainCheck\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Router;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * {@inhericdoc}
     */
    protected $dontReport = [
        //
    ];

    /**
     * {@inhericdoc}
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * {@inheritdoc}
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * {@inheritdoc}
     */
    public function render($request, Exception $e)
    {
        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        } else if ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($e);

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } else if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        } else if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        // This is an API and as such we will always return a JSON exception
        return $this->prepareJsonResponse($request, $e);
    }

    /**
     * {@inhericdoc}
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['message' => $exception->getMessage()], 401);
    }

    /**
     * {@inhericdoc}
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        return $this->invalidJson($request, $e);
    }
}
