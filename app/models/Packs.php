<?php

    /**
     * Packs Model
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace App\Models;

    use Core\Model;

    /**
     * Class Packs
     *
     * @package App\Models
     */
    class Packs extends Model
    {
        /**
         * Events
         *
         * @param array $req
         * @return array|bool
         */
        function events($req = array()) {
            return $this->belongsToMany('Events', $req);
        }
    }
