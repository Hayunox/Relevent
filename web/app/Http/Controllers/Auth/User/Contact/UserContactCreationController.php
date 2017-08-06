<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 30/07/2017
 * Time: 11:56.
 */

namespace App\Http\Controllers\Auth\User\Contact;

use App\Database\UserContact;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;

class UserContactCreationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
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
        $this->getValidationFactory()->make($data, [
            'new_contact_user_id'   => 'required|integer|max:12',
        ]);
    }

    /**
     * Create a new user instance after a valid registration
     *
     * @return array|string
     */
    protected function create()
    {
        // Get params
        $request = Request::instance();

        if (!$this->validator($request->all())->fails()) {

            $new_contact_user_id  = $request->request->get('new_contact_user_id');

            // User instance
            $contact = new UserContact($request->user_id);

            if ($contact->createContact($new_contact_user_id) > 1){
                return response()->json(json_encode(['USER_CONTACT_CREATED_SUCCESSFULLY']), 200);
            }
        }

        // failed
        return response()->json(['USER_CONTACT_CREATION_FAILED'], 400);
    }
}
