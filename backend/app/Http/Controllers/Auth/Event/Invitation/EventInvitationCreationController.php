<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 31/07/2017
 * Time: 21:53.
 */

namespace App\Http\Controllers\Auth\Event\Invitation;

use App\Database\EventInvitation;
use Illuminate\Support\Facades\Request;

class EventInvitationCreationController
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
            'new_guest_user_id'         => 'required|integer|max:12',
            'event_id'                  => 'required|integer|max:12',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return array|string
     */
    protected function create()
    {
        // Get params
        $request = Request::instance();

        if (!$this->validator($request->all())->fails()) {
            $new_guest_user_id = $request->request->get('new_guest_user_id');
            $event_id = $request->request->get('event_id');

            // User instance
            $invitation = new EventInvitation($request->user_id, $event_id);

            if ($invitation->createInvitation($new_guest_user_id) > 1) {
                return response()->json(json_encode(['EVENT_INVIT_USER_CREATED_SUCCESSFULLY']), 200);
            }
        }

        // failed
        return response()->json(['EVENT_INVIT_USER_CREATE_FAILED'], 400);
    }
}
