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

class EventInvitationDataController
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
    protected function getUserInvitList()
    {
        // Get params
        $request = Request::instance();

        // User instance
        $userEventList = new EventInvitation($request->user_id, null);

        return response()->json($userEventList->getUserInvited(), 200);
    }
}
