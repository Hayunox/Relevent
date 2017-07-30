<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 30/07/2017
 * Time: 11:53
 */

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use web\app\DBUser;

class UserRegistrationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return string
     */
    protected function create(array $data)
    {
        // User instance
        $user = new DBUser(null);

        $res = $user->userCreate([
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // Registration successful
        if ($res > -1) {
            return response()->json((['USER_CREATED_SUCCESSFULLY']), 200);

        // Registration failed
        } else {
            return response()->json((['USER_CREATE_FAILED']), 400);
        }
    }
}