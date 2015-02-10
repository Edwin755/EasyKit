<?php
/**
 * Validation process
 *
 * @author Edwin Dayot <edwin.dayot@sfr.fr>
 * @copyright 2014
 */

namespace Core;

use DateTime;

/**
 * Class Validation
 *
 * @package Core
 */
class Validation
{

    /**
     * Validate a date
     *
     * @param $date
     * @param string $format
     * @return bool
     */
    static public function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $date = str_replace('T', ' ', $date);
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * Validate Email
     *
     * @param $email
     * @return bool
     */
    static public function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
    }
}
