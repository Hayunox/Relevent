<?php

namespace App\Http\Middleware;

use App\Database\DBUser;
use Closure;

class AuthAPI
{

    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userDB = new DBUser(null);
        $user   = $userDB->userKeyExists($request->user_key);
        if ($user) {
            return $next($request, $user);
        }

        return response('API_KEY_ACCESS_DENIED', 401);
    }
}
