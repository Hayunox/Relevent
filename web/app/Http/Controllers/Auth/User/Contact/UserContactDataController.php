<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 30/07/2017
 * Time: 11:57.
 */

namespace App\Http\Controllers\Auth\User\Contact;

use App\Database\UserContact;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class UserContactDataController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new user instance after a valid registration.
     * @return array|string
     */
    protected function getContact()
    {
        // Get params
        $request = Request::instance();

        // User instance
        $contact = new UserContact($request->user_id);

        return response()->json($contact->getUserContacts(), 200);
    }
}
