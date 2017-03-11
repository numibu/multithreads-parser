<?php namespace parser\checking;

class CheckDependency{
    
    public static $errorFlag = false;

    static function checkCPHPversion()
    {
        if (PHP_VERSION_ID > 70100) {
            $str = "-- PHP_VERSION : " . phpversion() . " version >= 7.1 is required" . PHP_EOL;
            return $str;
        }else{
            static::$errorFlag = true;
            return "Not that version of PHP" . PHP_EOL;
        }
    }
    
    static function checkCurl()
    {
        if (function_exists('curl_version')) {
            return "-- CURL_VERSION : " . curl_version()['version_number'] . PHP_EOL;
        }else{
            static::$errorFlag = true;
            return "No found CURL extansion" . PHP_EOL;
        }
    }
    
    static  function checkTreads()
    {
        if (define(PTHREADS_INHERIT_INI, true)) {
            return "-- pTreads : is true" . PHP_EOL;
        }else{
            static::$errorFlag = true;
            return "No found pTreads extension" . PHP_EOL;
        }
    }
    
}
