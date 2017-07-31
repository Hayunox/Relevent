<?php

namespace App\Api\Controllers;

use App\Http\Controllers\Controller;

class EventInvitationController extends Controller
{
    /*
    public function __invoke(Request $request, Response $response)
    {
        $verification = RestServer::getRequiredParams($response, ['new_guest_user_id', 'event_id']);

        // Parameters corresponds
        if ($verification['status']) {
            $authentication = RestServer::authenticate();

            // Authentication success
            if (is_int($authentication)) {
                return $this->invitationCreation($verification['response'], $response, $authentication);
            }

            return RestServer::createJSONResponse($response, 400, $authentication);
        }

        return RestServer::createJSONResponse($response, 400, $verification['response']);
    }

    public function invitationCreation($data, Response $response, $user_id)
    {
        // reading post params
        $new_guest_user_id = RestServer::getSecureParam($data['new_guest_user_id']);
        $event_id = RestServer::getSecureParam($data['event_id']);

        $connection = new DBConnection();

        // User validation
        $invitation = new DBEventInvitation($user_id, $event_id);

        // validating not existing invitation
        if ($invitation->isInvited($connection, $new_guest_user_id)) {
            $response = RestServer::createJSONResponse($response, 400, 'EVENT_INVIT_USER_EXISTS');

        // Invitation validated
        } else {
            $res = $invitation->createInvitation($connection, $new_guest_user_id);

            if ($res > -1) {
                $response = RestServer::createJSONResponse($response, 200, 'EVENT_INVIT_USER_CREATED_SUCCESSFULLY');
            } else {
                $response = RestServer::createJSONResponse($response, 400, 'EVENT_INVIT_USER_CREATE_FAILED');
            }
        }

        return $response;
    }
}

class RestEventInvitationChange
{
    public function __invoke(Request $request, Response $response)
    {
        $verification = RestServer::getRequiredParams($response, ['event_id', 'status']);

        // Parameters corresponds
        if ($verification['status']) {
            $authentication = RestServer::authenticate();

            // Authentication success
            if (is_int($authentication)) {
                return $this->invitationChange($verification['response'], $response, $authentication);
            }

            return RestServer::createJSONResponse($response, 400, $authentication);
        }

        return RestServer::createJSONResponse($response, 400, $verification['response']);
    }

    public function invitationChange($data, Response $response, $user_id)
    {
        // reading post params
        $event_id = RestServer::getSecureParam($data['event_id']);
        $status = RestServer::getSecureParam($data['status']);

        $connection = new DBConnection();

        // User validation
        $contact = new DBEventInvitation($user_id, $event_id);

        $contact->setInvitationAcceptation($connection, $status);

        $response = RestServer::createJSONResponse($response, 200, 'EVENT_INVIT_USER_CHANGED_SUCCESSFULLY');

        return $response;
    }
}

class RestEventUserGetInvitation
{
    public function __invoke(Request $request, Response $response, $args = [])
    {
        $authentication = RestServer::authenticate();

        // Authentication success
        if (is_int($authentication)) {
            return $this->eventInvitationById($response, $request);
        }

        return RestServer::createJSONResponse($response, 400, $authentication);
    }

    public function eventInvitationById(Response $response, Request $request)
    {
        $connection = new DBConnection();

        $route = $request->getAttribute('route');
        $user_id = RestServer::getSecureParam($route->getArgument('id'));

        // User validation
        $invitation = new DBEventInvitation($user_id, null);

        return RestServer::createJSONResponse($response, 200, $invitation->getUserInvited($connection));
    }*/
}
