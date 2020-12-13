<?php
/**
 * Author: Vadims Prilepisevs
 * Date: 13.12.2020
 * Time: 19:16
 */

namespace App\Config;


class Config
{
     public $PAGINATION_LIMIT = 10;

     public $EMPTY_MESSAGE = 'Please enter your email address.';

     public $ADDRESS_EXISTS_MESSAGE = 'This address is already registered.';

     public $NOT_VALID_EMAIL_MESSAGE = 'Please provide a valid e-mail address.';

     public $IS_COLUMBIA_MESSAGE = 'We are not accepting subscriptions from Columbia.';

     public $NOT_CHECKED_MESSAGE = 'You must accept the terms and conditions.';

     public $SERVER_ERROR_MESSAGE = 'Server Error.';

}