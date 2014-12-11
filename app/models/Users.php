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
            $req['fields'] = array(
                'medias.medias_id',
                'medias.medias_file',
                'medias.medias_type',
            );
            return $this->hasOne('Medias', $req);
        }
    }
