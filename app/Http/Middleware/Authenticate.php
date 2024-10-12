<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if ($request->expectsJson()) {
            if ($token = $request->cookie('jwt')) {
                $decryptedToken = decrypt($token);
                $request->headers->set('Authorization', 'Bearer ' . $decryptedToken);
            } else if ($request->header('Authorization')) {
                $request->headers->set('Authorization', $request->header('Authorization'));
            }
        }

        $this->authenticate($request, $guards);
        return $next($request);
    }
}
