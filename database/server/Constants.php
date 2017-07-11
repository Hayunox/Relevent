<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 11/07/2017
 * Time: 19:32
 */

abstract class UserCreation{
    const USER_CREATED_SUCCESSFULLY = 0;
    const USER_CREATE_FAILED = 1;
    const USER_NICKNAME_EXISTED = 2;
    const USER_MAIL_EXISTED = 3;
}