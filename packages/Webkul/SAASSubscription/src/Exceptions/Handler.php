<?php

namespace Webkul\SAASSubscription\Exceptions;

use Exception;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ResourceLimitExceed) {
            session()->flash('warning', $exception->getMessage());

            return redirect()->back();
        }

        return parent::render($request, $exception);
    }
}