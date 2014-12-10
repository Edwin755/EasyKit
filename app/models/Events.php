<?php

    /**
     * Created by PhpStorm.
     * User: H3yden
     * Date: 10/12/2014
     * Time: 12:05
     */

    namespace App\Models;

    use Core\Model;

    class Events extends Model {

        function medias() {
            return $this->hasMany('Medias');
        }
    }