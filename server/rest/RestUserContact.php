<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 27/07/2017
 * Time: 20:34
 */

namespace server\rest;

require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../database/DBConnection.php';
require_once __DIR__.'/../database/DBUserContact.php';
require_once __DIR__.'/RestServer.php';

use server\database\DBConnection;
use server\database\DBUserContact;
use Slim\Http\Request;
use Slim\Http\Response;

class RestUserContactCreation
{
    /**
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
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

    /**
     * @param $data
     * @param Response $response
     * @param $user_id
     * @return Response
     */
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
    /**
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
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

    /**
     * @param $data
     * @param Response $response
     * @param $user_id
     * @return Response
     */
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
            return $this->userContactById($response, $request);
        }

        return RestServer::createJSONResponse($response, 400, $authentication);
    }

    /**
     * @param Response $response
     * @param Request  $request
     *
     * @return Response
     */
    public function userContactById(Response $response, Request $request)
    {
        $connection = new DBConnection();

        $route = $request->getAttribute('route');
        $user_id = RestServer::getSecureParam($route->getArgument('id'));

        // User validation
        $contact = new DBUserContact($user_id);

        return RestServer::createJSONResponse($response, 200, $contact->getUserContacts($connection));
    }
}