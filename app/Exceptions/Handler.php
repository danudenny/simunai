<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
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
     * @param  \Throwable  $e
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        // check api guard for unauthorized responses
        /*if(auth()->guard('api')->check()) {
            return response()->json([
             'message' => 'Sorry! This action is unauthorized'
            ],401);
        }*/
        if($this->isHttpException($e))
        {
            switch ($e->getStatusCode()) 
                {
                // not found
                case 404:
                return redirect()->guest('/');
                break;

                // internal error
                case '500':
                return redirect()->guest('/');
                break;

                default:
                    return $this->renderHttpException($e);
                break;
            }
        }
    }
}
