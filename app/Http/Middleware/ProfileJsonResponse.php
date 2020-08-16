<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;

class ProfileJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $response = $next($request);

        // check if debugbar is enabled
        if(!app()->bound('debugbar') || !app('debugbar')->isEnabled()) {
            return $response;
        }

        // profile the json response
        if($response instanceof JsonResponse && $request->has('_debug')) {
            // return data from response and debugbar
        //    $response->setData(array_merge($response->getData(true), [
        //        '_debugbar' => app('debugbar')->getData()
        //    ]));
        // return only queries
           $response->setData(array_merge($response->getData(true), [
               '_debugbar' => Arr::only(app('debugbar')->getData(), 'queries')
           ]));
        }

        return $response;
    }
}
