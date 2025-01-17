<?php

/**
 * Application file
 *
 * @author Edwin Dayot <edwin.dayot@sfr.fr>
 * @copyright 2014
 */

date_default_timezone_set('Europe/Paris');

return array(

    /**
     * Session
     */
    'session_name'  => 'EasyKit_session',

    /**
     * Cookie
     */
    'cookie_name'   => 'EasyKit_cookie',
    'cookie_time'   => 3600 * 24 * 28 * 3,

    /**
     * Security
     */
    'secure_key'    => 'o1Xc7m9KJ2S9X8307jFK67Fr',
    'debug'         => false,

    /**
     * Facebook
     */
    'fb_app_id'         => '1504498789824094',
    'fb_app_secret'     => '3827bbf168228f67cd109e4281bfacca',
    'fb_permissions'    => [
        'email',
        'user_birthday',
    ],

    /**
     * Email
     */
    'mail_smtp'          => 'mail.easykit.me',
    'mail_port'          => 25,
    'mail_username'      => 'hello@easykit.me',
    'mail_password'      => 'helloeemi'

);
