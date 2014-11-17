<?php

    /**
     * Database file
     */

    return array(

        /**
         * PDO Fetch Style
         */
        'fetch' => PDO::FETCH_CLASS,

        /**
         * Default database connection name
         */
        'default' => 'local',


        /**
         * Database connections
         */
        'connections' => array(

            'local' => array(
                'host'      => 'localhost',
                'database'  => 'easykit',
                'username'  => 'root',
                'password'  => '',
                'charset'   => 'utf8',
                'prefix'    => 'ek_'
            ),
        )

    );
