<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 30/07/2017
 * Time: 11:53.
 */

namespace App\Http\Controllers;

use App\Database\User;
use Illuminate\Support\Facades\Request;

class UserRegistrationController extends Controller
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
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // email|
    protected function validator(array $data)
    {
        return $this->getValidationFactory()->make($data, [
            'nickname'  => 'required|string|max:255|unique:user',
            'mail'      => 'required|string|max:255|unique:user',
            'password'  => 'required|string|min:4',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return string
     */
    protected function create()
    {
        // Get params
        $request = Request::instance();

        if(!$this->validator($request->all())->fails()) {
            // User instance
            $user = new User(null);

            // DB::connection()->getPdo()->quote
            $nickname = preg_replace('/[^A-Za-z0-9\-@\.\-]/', '', $request->request->get('nickname'));
            $password = preg_replace('/[^A-Za-z0-9\-@\.\-]/', '', $request->request->get('password'));
            $mail = preg_replace('/[^A-Za-z0-9\-@\.\-]/', '', $request->request->get('mail'));

            // validating email address
            // TODO : use unique
            if ($user->userMailExists($mail)) {
                return response()->json(['USER_MAIL_EXISTS'], 400);

                // validating nickname
            } elseif ($user->userNickNameExists($nickname)) {
                return response()->json(['USER_NICKNAME_EXISTS'], 400);

                // User validated
            } else {
                $res = $user->userCreate([
                    'nickname' => $nickname,
                    'mail' => $mail,
                    'password' => $password,
                ]);

                // Registration successful
                if ($res !== null) {
                    return response()->json('USER_CREATED_SUCCESSFULLY', 200);
                }
            }
        }
        return response()->json('USER_CREATE_FAILED', 400);
    }
}
