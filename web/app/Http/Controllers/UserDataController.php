<?php
namespace App\Http\Controllers;

use App\Database\DBUser;
use Illuminate\Contracts\Validation\Validator;

class UserDataController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        //$this->middleware('auth');
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
            'id' => 'required|integer|max:12',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param string $data
     * @return array|string
     */
    protected function getDataById(String $data)
    {
        // User instance
        $user = new DBUser((int) $data);

        return $user->getUserData();
    }
}
