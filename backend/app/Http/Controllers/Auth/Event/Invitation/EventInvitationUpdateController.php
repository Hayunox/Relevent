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

class EventInvitationUpdateController
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
            'event_id'      => 'required|integer|max:12',
            'status'        => 'required|integer|max:2',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return string
     */
    protected function update()
    {
        // Get params
        $request = Request::instance();

        if (!$this->validator($request->all())->fails()) {
            $event_id = $request->request->get('event_id');
            $status = $request->request->get('status');

            // User instance
            $contact = new EventInvitation($request->user_id, $event_id);

            $contact->setInvitationAcceptation($status);

            return response()->json(json_encode(['EVENT_INVIT_CHANGED_SUCCESSFULLY']), 200);
        }

        // failed
        return response()->json(['EVENT_INVIT_UPDATE_FAILED'], 400);
    }
}
