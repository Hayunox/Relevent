<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 27/07/2017
 * Time: 20:34.
 */

namespace server\rest;

require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../database/DBConnection.php';
require_once __DIR__.'/../database/DBEventInvitation.php';
require_once __DIR__.'/RestServer.php';

use server\database\DBConnection;
use server\database\DBEventInvitation;
use Slim\Http\Request;
use Slim\Http\Response;

class RestEventInvitationCreation
{
    /**
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
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

    /**
     * @param $data
     * @param Response $response
     * @param $user_id
     *
     * @return Response
     */
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
    /**
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
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

    /**
     * @param $data
     * @param Response $response
     * @param $user_id
     *
     * @return Response
     */
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
    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $args = [])
    {
        $authentication = RestServer::authenticate();

        // Authentication success
        if (is_int($authentication)) {
            return $this->eventInvitationById($response, $request);
        }

        return RestServer::createJSONResponse($response, 400, $authentication);
    }

    /**
     * @param Response $response
     * @param Request  $request
     *
     * @return Response
     */
    public function eventInvitationById(Response $response, Request $request)
    {
        $connection = new DBConnection();

        $route = $request->getAttribute('route');
        $user_id = RestServer::getSecureParam($route->getArgument('id'));

        // User validation
        $invitation = new DBEventInvitation($user_id, null);

        return RestServer::createJSONResponse($response, 200, $invitation->getUserInvited($connection));
    }
}
