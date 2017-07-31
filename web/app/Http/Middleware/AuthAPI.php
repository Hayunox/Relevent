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
        // TODO : improve
        $authorization = $_SERVER['HTTP_AUTHORIZATION'];

        if (isset($authorization)) {
            $user = new DBUser(null);

            // validating user key
            $keyExists = $user->userKeyExists($authorization);
            if ($keyExists) {
                // user_id
                $request->user_id = $keyExists;
                return $next($request);
            } else {
                // user key is not present in users table
                return response('API_KEY_ACCESS_DENIED', 401);
            }
        } else {
            // user key is missing in header
            return response('USER_KEY_NOT_FOUND', 401);
        }
    }
}
