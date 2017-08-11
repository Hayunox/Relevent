<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 31/07/2017
 * Time: 21:36.
 */

namespace App\Http\Controllers\Auth\Event;

use App\Database\Event;
use App\Http\Middleware\AuthAPI;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;

class EventCreationController extends Controller
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
        return $this->getValidationFactory()->make($data, [
            'name'            => 'required|string|max:255',
            'description'     => 'required|string|max:512',
            'date'            => 'required|integer',
            'address'         => 'required|string|max:255',
            'theme'           => 'required|integer',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return array|string
     *
     * @internal param string $data
     */
    protected function create()
    {

        // Event instance
        $event = new Event(null);

        // Get params
        $request = Request::instance();

        if (!$this->validator($request->all())->fails()) {
            // DB::connection()->getPdo()->quote
            $name = preg_replace('/[^A-Za-z0-9\-@\.\-]/', '', $request->request->get('name'));
            $date = preg_replace('/[^A-Za-z0-9\-@\.\-]/', '', $request->request->get('date'));
            $description = preg_replace('/[^A-Za-z0-9\-@\.\-]/', '', $request->request->get('description'));
            $address = preg_replace('/[^A-Za-z0-9\-@\.\-]/', '', $request->request->get('address'));
            $theme = preg_replace('/[^A-Za-z0-9\-@\.\-]/', '', $request->request->get('theme'));

            $event->eventCreate([
                'event_user_id'     => $request->user_id,
                'event_name'        => $name,
                'event_description' => $description,
                'event_date'        => $date,
                'event_address'     => $address,
                'event_theme'       => $theme,
                'event_secret'      => 0,
            ]);

            return response()->json('EVENT_CREATED_SUCCESSFULLY', 200);
        }

        return response()->json('EVENT_CREATE_FAILED', 400);
    }
}
