<?php

namespace App\Karigor\Helpers;

class ConfigHelper
{
    private static $salt1 = '0443652c6e5b0b3a';
    private static $salt2 = '339b166905a09d7f';

    private static $paginatePerPage = 20;

    /**
     * undocumented function
     *
     * @param string $saltName
     * @return mixed
     **/
    public function getSaltData($saltName){
        switch ($saltName) {
            case 'salt1':
                return self::$salt1;
                break;

            case 'salt2':
                return self::$salt2;
                break;
            
            default:
                return null;
                break;
        }
    }
}