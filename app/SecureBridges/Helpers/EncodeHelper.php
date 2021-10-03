<?php

namespace App\Karigor\Helpers;

class EncodeHelper
{
    /**
     * @var App\Karigor\Helpers\ConfigHelper
     **/
    protected $configHelper;

    private $salt1;
    private $salt2;

    function __construct()
    {
        $this->configHelper = new ConfigHelper();
        $this->salt1 = $this->configHelper->getSaltData('salt1');
        $this->salt2 = $this->configHelper->getSaltData('salt2');
    }


    /**
     * encode a string on base64 method
     *
     * @param string $str
     * @return string
     **/
    public function encodeData($str){
        $encoded = $this->base64UrlEncode($str);
        return $encoded;
    }

    /**
     * decode a string on base64 method
     *
     * @param string $str
     * @return string
     **/
    public function decodeData($str){
        $decoded = $this->base64UrlDecode($str);
        $posSalt1 = strpos($decoded, $this->salt1);
        $posSalt2 = strpos($decoded, $this->salt2);

        $endCharPos = 16;
        $start = $posSalt1+$endCharPos;
        $end = $posSalt2-$start;
        return substr($decoded, $start, $end);
    }

    function base64UrlEncode($input) {
        return strtr(base64_encode($this->salt1.$input.$this->salt2), '+/=', '~_-');
    }

    function base64UrlDecode($input) {
     return base64_decode(strtr($input, '~_-', '+/='));
    }
}



