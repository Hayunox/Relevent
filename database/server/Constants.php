<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 11/07/2017
 * Time: 19:32
 */

abstract class UserCreation{
    const USER_CREATED_SUCCESSFULLY = "OK";
    const USER_CREATE_FAILED = "KO # ";
    const USER_NICKNAME_EXISTED = "KO # Nickname";
    const USER_MAIL_EXISTED = "KO # Mail";
}

abstract class APIKey{
    const API_KEY_ACESS_DENIED = "KO # Key";
    const USER_KEY_NOT_FOUND = "KO # ";
}