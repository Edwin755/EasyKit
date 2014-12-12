<?php

    /**
     * Users Model
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace App\Models;

    use Core\Model;

    /**
     * Users
     */
    class Users extends Model
    {

        /**
         * @param array $req
         * @return array|bool
         */
        function media($req = array()) {
            return $this->hasOne('Medias', $req);
        }
    }
