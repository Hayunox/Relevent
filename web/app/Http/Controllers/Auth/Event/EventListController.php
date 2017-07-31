<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 31/07/2017
 * Time: 21:37.
 */

namespace App\Http\Controllers\Auth\Event;

use App\Database\Event;
use App\Http\Middleware\AuthAPI;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;

class EventListController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(AuthAPI::class);
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
     * @return array|string
     */
    protected function getEventOwnUserList()
    {
        // Event instance
        $event = new Event(null);

        $request = Request::instance();

        return response()->json(json_encode($event->eventUserList($request->user_id)), 200);
    }
}
