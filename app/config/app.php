<?php

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
        'debug'         => gethostname() == 'Heyden' ? true : false,


    );
