<?php namespace parser\threads;

use parser\Parser;

class CarGenModelMiningProcess extends \Thread {
    
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
            echo "\n" .spl_object_hash($this) . " <- hash of thread" . "\n";
            echo "Serching CarGenModel \n";
            $carModel = NULL;
            $context = $this;
            
            $provider->synchronized(function($provider) use (&$carModel, $context){
                $carModel = $provider->getNextCarModel($context);
            }, $provider);
            
            if ( $carModel !== NULL ) {
                $result = Parser::miningCarGenModel($carModel);
                $this->returnCarGenModel($result);
            }

            usleep(5000);
        }while(!$this->endFlag);
        
        echo "\n EXIT FROM CarGenModel THREAD";
    }
    
    
    public function returnCarGenModel($result)
    {
        $provider = $this->worker->getProvider();
        $context = $this;
        
        $provider->synchronized(function($provider) use ($result , $context){
            $provider->addCarGenModel($result, $context);
        }, $provider);
    }
    
    
}
