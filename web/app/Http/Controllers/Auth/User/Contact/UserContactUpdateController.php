<?php

namespace App\Http\Controllers\Auth\User\Contact;

use App\Database\UserContact;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class UserContactUpdateController extends Controller
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
        return $this->getValidationFactory()->make($data, [
            'contact_id'    => 'required|integer|max:12',
            'status'        => 'required|integer|max:2',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * @return string
     */
    protected function update()
    {
        // Get params
        $request = Request::instance();

        if (!$this->validator($request->all())->fails()) {

            $contact_id     = $request->request->get('contact_id');
            $status          = $request->request->get('status');

            // User instance
            $contact = new UserContact($request->user_id);

            $contact->setContactAcceptation($contact_id, $status);
            return response()->json(json_encode(['USER_CONTACT_CHANGED_SUCCESSFULLY']), 200);
        }

        // failed
        return response()->json(['USER_CONTACT_UPDATE_FAILED'], 400);
    }
}
