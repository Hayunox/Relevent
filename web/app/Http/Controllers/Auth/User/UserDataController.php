<?php

namespace App\Http\Controllers;

use App\Database\User;
use App\Http\Middleware\AuthAPI;
use Illuminate\Support\Facades\Request;

class UserDataController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(AuthAPI::class);
    }

    /**
     * Create a new user instance after a valid registration.
     * @return array|string
     */
    protected function getUserInvitList()
    {
        // Get params
        $request = Request::instance();

        // User instance
        $user = new User($request->user_id);

        return response()->json($user->getUserData(), 200);
    }
}
