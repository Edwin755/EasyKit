<?php

/**
 * Steps Model
 *
 * @author Edwin Dayot <edwin.dayot@sfr.fr>
 * @copyright 2014
 */

namespace App\Models;

use Core\Model;

/**
 * Class Steps
 *
 * @package App\Models
 */
class Steps extends Model
{

    /**
     * Packs
     *
     * @param array $req
     * @return array|bool
     */
    function pack($req)
    {
        return $this->belongsTo('Packs', $req);
    }
}
