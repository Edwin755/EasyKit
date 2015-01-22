<?php

/**
 * Database file
 *
 * @author Edwin Dayot <edwin.dayot@sfr.fr>
 * @copyright 2014
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
            'host'      => '91.121.220.30',
            'database'  => 'easykit',
            'username'  => 'hello',
            'password'  => 'world',
            'charset'   => 'utf8',
            'prefix'    => 'ek_'
        ),
    )

);
