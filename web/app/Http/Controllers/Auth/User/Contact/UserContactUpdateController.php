<?php
namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use web\app\Database\DBUserContact;

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
        return Validator::make($data, [
            'contact_id'    => 'required|integer|max:12',
            'status'        => 'required|integer|max:2',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return string
     */
    protected function update(array $data)
    {
        // new instance
        //$contact = new DBUserContact($user_id);

        //$contact->setContactAcceptation($connection, $contact_id, $status);

        //return $user->setContactAcceptation($data['contact_id'], $data['status']);
    }








    /**
    public function __invoke(Request $request, Response $response)
    {
        $verification = RestServer::getRequiredParams($response, ['new_contact_user_id']);

        // Parameters corresponds
        if ($verification['status']) {
            $authentication = RestServer::authenticate();

            // Authentication success
            if (is_int($authentication)) {
                return $this->contactCreation($verification['response'], $response, $authentication);
            }

            return RestServer::createJSONResponse($response, 400, $authentication);
        }

        return RestServer::createJSONResponse($response, 400, $verification['response']);
    }

    public function contactCreation($data, Response $response, $user_id)
    {
        // reading post params
        $new_contact_user_id = RestServer::getSecureParam($data['new_contact_user_id']);

        $connection = new DBConnection();

        // User validation
        $contact = new DBUserContact($user_id);

        // validating not existing contact
        if ($contact->isContact($connection, $new_contact_user_id)) {
            $response = RestServer::createJSONResponse($response, 400, 'USER_CONTACT_EXISTS');

        // User validated
        } else {
            $res = $contact->createContact($connection, $new_contact_user_id);

            if ($res > -1) {
                $response = RestServer::createJSONResponse($response, 200, 'USER_CONTACT_CREATED_SUCCESSFULLY');
            } else {
                $response = RestServer::createJSONResponse($response, 400, 'USER_CONTACT_CREATE_FAILED');
            }
        }

        return $response;
    }
}

class RestUserContactChange
{

    public function __invoke(Request $request, Response $response)
    {
        $verification = RestServer::getRequiredParams($response, ['contact_id', 'status']);

        // Parameters corresponds
        if ($verification['status']) {
            $authentication = RestServer::authenticate();

            // Authentication success
            if (is_int($authentication)) {
                return $this->contactChange($verification['response'], $response, $authentication);
            }

            return RestServer::createJSONResponse($response, 400, $authentication);
        }

        return RestServer::createJSONResponse($response, 400, $verification['response']);
    }

    public function contactChange($data, Response $response, $user_id)
    {
        // reading post params
        $contact_id = RestServer::getSecureParam($data['contact_id']);
        $status = RestServer::getSecureParam($data['status']);

        $connection = new DBConnection();

        // User validation
        $contact = new DBUserContact($user_id);

        $contact->setContactAcceptation($connection, $contact_id, $status);

        $response = RestServer::createJSONResponse($response, 200, 'USER_CONTACT_CHANGED_SUCCESSFULLY');

        return $response;
    }
}

class RestUserGetContacts
{
    public function __invoke(Request $request, Response $response, $args = [])
    {
        $authentication = RestServer::authenticate();

        // Authentication success
        if (is_int($authentication)) {
            return $this->userContactById($response, $request);
        }

        return RestServer::createJSONResponse($response, 400, $authentication);
    }

    public function userContactById(Response $response, Request $request)
    {
        $connection = new DBConnection();

        $route = $request->getAttribute('route');
        $user_id = RestServer::getSecureParam($route->getArgument('id'));

        // User validation
        $contact = new DBUserContact($user_id);

        return RestServer::createJSONResponse($response, 200, $contact->getUserContacts($connection));
    }*/
}
