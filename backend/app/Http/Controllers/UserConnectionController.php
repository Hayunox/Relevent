<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 30/07/2017
 * Time: 11:52.
 */

namespace App\Http\Controllers;

use App\Database\User;
use Illuminate\Support\Facades\Request;

class UserConnectionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
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
        return $this->getValidationFactory()->make($data, [
            'nickname' => 'required|string|max:255',
            'password' => 'required|string|min:4',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return string
     */
    protected function login()
    {
        // Get params
        $request = Request::instance();

        if (!$this->validator($request->all())->fails()) {
            // User instance
            $user = new User(null);

            $nickname = preg_replace('/[^A-Za-z0-9\-@\.\-]/', '', $request->request->get('nickname'));
            $password = preg_replace('/[^A-Za-z0-9\-@\.\-]/', '', $request->request->get('password'));

            // Connection successful
            if (is_array($user_data = $user->tryLogin($nickname, $password))) {
                return response()->json($user_data, 200);
            }
        }
        // Connection failed
        return response()->json(['USER_LOGIN_FAILED'], 400);
    }
}
