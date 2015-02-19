<?php
/**
 * Created by PhpStorm.
 * User: Heyden
 * Date: 19/02/2015
 * Time: 16:05
 */

namespace Core\Helpers;


class StringHelper
{

    /**
     * Generaye Random String
     *
     * @param int $length
     *
     * @return string
     */
    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}