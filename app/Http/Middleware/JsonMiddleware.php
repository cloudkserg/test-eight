<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 20.02.18
 * Time: 1:35
 */

namespace App\Http\Middleware;


class JsonMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($request->isJson())
        {
            //fetch your json data, instead of doing the way you were doing
            $json_array = $request->json()->all();

            //now we replace our json data with our new json data without the last element
            $request->json()->replace($json_array);
        }

        return $next($request);

    }


}