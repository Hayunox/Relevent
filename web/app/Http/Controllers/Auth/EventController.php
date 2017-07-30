<?php
namespace App\Api\Controllers;

use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
    public function __invoke(Request $request, Response $response)
    {
        $verification = RestServer::getRequiredParams($response, ['name', 'date', 'description', 'address', 'theme']);

        // Parameters corresponds
        if ($verification['status']) {
            $authentication = RestServer::authenticate();

            // Authentication success
            if (is_int($authentication)) {
                return $this->eventCreation($verification['response'], $response, $authentication);
            }

            return RestServer::createJSONResponse($response, 400, $authentication);
        }

        return RestServer::createJSONResponse($response, 400, $verification['response']);
    }

    public function eventCreation($data, Response $response, $user_id)
    {
        // reading post params
        $name = RestServer::getSecureParam($data['name']);
        $date = RestServer::getSecureParam($data['date']);
        $description = RestServer::getSecureParam($data['description']);
        $address = RestServer::getSecureParam($data['address']);
        $theme = RestServer::getSecureParam($data['theme']);

        $connection = new DBConnection();

        // event validation
        $event = new DBEvent(null);

        $res = $event->eventCreate($connection, [
            'event_user_id'             => $user_id,
            'event_name'                => $name,
            'event_description'         => $description,
            'event_date'                => $date,
            'event_address'             => $address,
            'event_theme'               => $theme,
            'event_secret'              => 0,
        ]);

        if ($res > -1) {
            $response = RestServer::createJSONResponse($response, 200, 'EVENT_CREATED_SUCCESSFULLY');
        } else {
            $response = RestServer::createJSONResponse($response, 400, 'EVENT_CREATE_FAILED');
        }

        return $response;
    }
}

class RestEventEdit
{
}

class RestEventUserListOwn
{
    public function __invoke(Request $request, Response $response)
    {
        $authentication = RestServer::authenticate();

        // Authentication success
        if (is_int($authentication)) {
            return $this->eventUserList($response, $authentication);
        }

        return RestServer::createJSONResponse($response, 400, $authentication);
    }

    public function eventUserList(Response $response, $user_id)
    {
        $connection = new DBConnection();

        // event validation
        $event = new DBEvent(null);

        return RestServer::createJSONResponse($response, 200, json_encode($event->eventUserList($connection, $user_id)));
    }*/
}
