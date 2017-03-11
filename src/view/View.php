<?php namespace parser\view;

class View {
    
    public static function start()
    {
        echo " :::::::: Parser ::::::::::: " . PHP_EOL;
        echo \parser\checking\CheckDependency::checkCPHPversion();
        echo \parser\checking\CheckDependency::checkCurl();
        echo \parser\checking\CheckDependency::checkTreads();
        echo " ----------------------------------- " . PHP_EOL;
        echo "pthreads requires a build of PHP with ZTS (Zend Thread Safety) "
        . "enabled ( --enable-maintainer-zts or --enable-zts on Windows )" . PHP_EOL;
        echo " ----------------------------------- " . PHP_EOL;
        
        if (\parser\checking\CheckDependency::$errorFlag === true )
        { echo "\n Error, exit... \n";}
    }

    public static function render($data, $newLine = false)
    {
        if ($newLine) echo "\n";
        echo "\r";   //\r\033[K\r";//"\r";
        echo $data;
    }
    
    public static function load()
    {
        $startTime = time();
        for ( $i = true; $i;) {
            $t = (string)( time()-$startTime );
            echo "processing... {$t} \r";
            sleep(1);
        }
    }
    
    public static function choise()
    {
        $choice = '';
        while( $choice !== "exit\n" ){
            echo PHP_EOL . 'parser>';
            $choice = (string)(fgets(STDIN));
            echo self::render($choice);
            sleep(1);
            //echo $choice . " \r";
        }
    }
}
