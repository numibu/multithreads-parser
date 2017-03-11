<?php namespace parser\threads;

use parser\Parser;

class CarModelMiningProcess extends \Thread {
    
    public $storage; 
    public $endFlag = false; 
    
    public function __construct($storage) 
    {
        $this->storage = $storage;
    }
    
    public function run()
    {
        $provider = $this->worker->getProvider();
        
        do {
            echo "\n" .spl_object_hash($this). " <- hash of thread" . "\n";
            echo "Serching CarModel \n";
            $brend = NULL;
            $context = $this;
            $provider->synchronized(function($provider) use (&$brend, $context){
                $brend = $provider->getNextBrend($context);
            }, $provider);
            
            if ($brend !== NULL) {
                $result = Parser::miningCarModel($brend);
                $this->returnCarModel($result);
            }

            usleep(5000);
        }while(!$this->endFlag);
        
        echo "\n EXIT FROM CarModel Maining THREAD";
    }
    
    
    public function returnCarModel($result){
        $provider = $this->worker->getProvider();
        $context = $this;
        $provider->synchronized(function($provider) use ($result , $context){ 
            $provider->addCarModel($result, $context);
        }, $provider);
    }
    
    
}
