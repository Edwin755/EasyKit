<?php
/**
 * Created by PhpStorm.
 * User: Heyden
 * Date: 19/02/2015
 * Time: 16:00
 */

namespace Core\Helpers;


class FileHelper
{
    /**
     * Upload file
     *
     * @param $file
     * @param array $permission
     */
    public static function upload($files, $permission = array())
    {
        $return = [];

        foreach ($files as $file) {
            if (in_array($file['type'], $permission)) {
                $directory = __DIR__ . '/../public/uploads/';
                $url = HTML::link('uploads') . '/';

                $type = explode('/', $file['type']);

                foreach ($type as $value) {
                    if (!is_dir($directory . $value)) {
                        mkdir($directory . $value, 0755);
                    }

                    $directory .= $value . '/';
                    $url .= $value . '/';
                }

                $filename = md5(uniqid(mt_rand(), true)) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                $directory .= $filename;
                $url .= $filename;

                if (move_uploaded_file($file['tmp_name'], $directory)) {
                    $return[] = [
                        'success' => true,
                        'file' => realpath($directory),
                        'url' => $url,
                        'filename' => pathinfo($directory, PATHINFO_FILENAME),
                        'extension' => pathinfo($directory, PATHINFO_EXTENSION)
                    ];
                } else {
                    $return[] = [
                        'success' => false
                    ];
                }
            } else {
                $return[] = [
                    'success'   => false
                ];
            }
        }

        return $return;
    }
}