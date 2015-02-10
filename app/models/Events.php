<?php

/**
 * Created by PhpStorm.
 * User: H3yden
 * Date: 10/12/2014
 * Time: 12:05
 */

namespace App\Models;

use Core\Model;

/**
 * Class Events
 *
 * @package App\Models
 */
class Events extends Model
{

    /**
     * Medias
     *
     * @param array $req
     * @return array|bool
     */
    function medias($req = array())
    {
        return $this->hasMany('Medias', $req);
    }

    /**
     * User
     *
     * @param array $req
     * @return array|bool
     */
    function user($req = array())
    {
        return $this->hasOne('Users', $req);
    }
}