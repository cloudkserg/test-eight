<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CheckApiKeyMiddleware
{
    const API_KEY_PARAM = 'apiKey';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->get(self::API_KEY_PARAM, '') !== getenv('APP_API_KEY')) {
            throw new AccessDeniedHttpException('Not allowed');
        }
        return $next($request);
    }
}
