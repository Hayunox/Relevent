<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 30/07/2017
 * Time: 11:52
 */

namespace App\Http\Controllers;

use App\Database\DBUser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Input;

class UserConnectionController  extends Controller
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
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * @return string
     */
    protected function login()
    {
        // User instance
        $user = new DBUser(null);

        // Connection successful
        if (is_array($user_data = $user->tryLogin(Input::get('nickname'), bcrypt(Input::get('password'))))) {
            return response()->json(([$user_data]), 200);

        // Connection failed
        } else {
            return response()->json((['USER_LOGIN_FAILED']), 400);
        }
    }
}