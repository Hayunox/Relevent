<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 30/07/2017
 * Time: 11:57
 */

namespace App\Http\Controllers\Auth\User\Contact;

use App\Database\DBUserContact;
use App\Http\Controllers\Controller;

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
     *
     * @param array $data
     * @return array|string
     */
    protected function getContact(Array $data)
    {
        // UserContact instance
        $contact = new DBUserContact($data);

        return $contact->getUserContacts();
    }
}